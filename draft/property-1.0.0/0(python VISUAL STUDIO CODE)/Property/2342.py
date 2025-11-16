import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense, Dropout
from tensorflow.keras.optimizers import Adam
from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics import mean_squared_error, mean_absolute_error, r2_score

# 1. Load and preprocess data dengan fitur tambahan
def compute_MA(data, window=7):
    return data.rolling(window=window).mean()

df = pd.read_csv("data_harga.csv", parse_dates=["date"], index_col="date")
df['MA7'] = compute_MA(df['close'])
df.dropna(inplace=True)  # Hapus nilai NA dari moving average

# 2. Normalisasi data dengan MinMaxScaler
scaler = MinMaxScaler(feature_range=(0,1))
df_scaled = scaler.fit_transform(df[['close', 'MA7']])

# 3. Fungsi pembuatan dataset dengan walk-forward validation
def create_walk_forward_data(data, train_window=50, test_window=14):
    X_train, y_train, X_test, y_test = [], [], [], []
    for i in range(len(data) - train_window - test_window):
        train_seq = data[i:i+train_window]
        test_seq = data[i+train_window:i+train_window+test_window]
        
        X_train.append(train_seq)
        y_train.append(data[i+train_window:i+train_window+test_window, 0])  # Prediksi close price
        
        if i == 0:  # Hanya buat test set dari akhir data
            X_test.append(train_seq)
            y_test.append(data[i+train_window:i+train_window+test_window, 0])
    
    return (np.array(X_train), np.array(y_train), 
            np.array(X_test[-1]).reshape(1,-1,2), np.array(y_test[-1]))

train_window = 50
test_window = 14
X_train, y_train, X_test, y_test = create_walk_forward_data(df_scaled, train_window, test_window)

# 4. Arsitektur model yang ditingkatkan
model = Sequential([
    LSTM(100, return_sequences=True, input_shape=(train_window, 2)),
    Dropout(0.3),
    LSTM(50, return_sequences=True),
    Dropout(0.3),
    LSTM(50),
    Dropout(0.3),
    Dense(25, activation='relu'),
    Dense(test_window)  # Prediksi multi-step sekaligus
])

optimizer = Adam(learning_rate=0.001, decay=1e-6)
model.compile(optimizer=optimizer, 
              loss='mse',
              metrics=['mae', tf.keras.metrics.RootMeanSquaredError()])

# 5. Pelatihan model dengan early stopping
history = model.fit(X_train, y_train, 
                    epochs=50, 
                    batch_size=32,
                    validation_data=(X_test, y_test),
                    callbacks=[tf.keras.callbacks.EarlyStopping(patience=5)])

# 6. Prediksi dengan confidence interval
def predict_with_uncertainty(model, input_data, n_iter=100):
    predictions = []
    for _ in range(n_iter):
        predictions.append(model.predict(input_data)[0])
    return np.mean(predictions, axis=0), np.std(predictions, axis=0)

# Prediksi 14 hari
y_pred, y_std = predict_with_uncertainty(model, X_test)
y_pred = scaler.inverse_transform(np.column_stack((y_pred, np.zeros_like(y_pred))))[:,0]
y_true = scaler.inverse_transform(np.column_stack((y_test[0], np.zeros_like(y_test[0]))))[:,0]

# 7. Evaluasi model
rmse = np.sqrt(mean_squared_error(y_true, y_pred))
mae = mean_absolute_error(y_true, y_pred)
r2 = r2_score(y_true, y_pred)

print(f"Performance Metrics:\nRMSE: {rmse:.2f}\nMAE: {mae:.2f}\nR²: {r2:.2f}")

# 8. Visualisasi dengan uncertainty
plt.figure(figsize=(12,6))
plt.plot(y_true, label='Actual Price', marker='o')
plt.plot(y_pred, label='Predicted Price', marker='x')
plt.fill_between(range(len(y_pred)), 
                 y_pred - 1.96*y_std, 
                 y_pred + 1.96*y_std,
                 alpha=0.2, color='gray', label='95% CI')
plt.title(f"14-Day Price Prediction\nRMSE: {rmse:.2f}, MAE: {mae:.2f}, R²: {r2:.2f}")
plt.legend()
plt.show()
