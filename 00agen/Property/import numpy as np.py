import numpy as np
import pandas as pd
import matplotlib.pyplot as plt
import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense, Dropout
from sklearn.preprocessing import MinMaxScaler

# 1. Ambil data historis (bisa dari Yahoo Finance atau MetaTrader)
df = pd.read_csv("data_harga.csv", parse_dates=["date"], index_col="date")

# 2. Preprocessing Data
scaler = MinMaxScaler(feature_range=(0,1))
df_scaled = scaler.fit_transform(df["close"].values.reshape(-1, 1))

# Fungsi untuk membuat dataset time series
def create_sequences(data, seq_length):
    X, y = [], []
    for i in range(len(data) - seq_length):
        X.append(data[i:i+seq_length])
        y.append(data[i+seq_length])
    return np.array(X), np.array(y)

seq_length = 50  # Gunakan 50 hari terakhir untuk prediksi
X, y = create_sequences(df_scaled, seq_length)

# Split data
train_size = int(len(X) * 0.8)
X_train, X_test = X[:train_size], X[train_size:]
y_train, y_test = y[:train_size], y[train_size:]

# 3. Model LSTM
model = Sequential([
    LSTM(50, return_sequences=True, input_shape=(seq_length, 1)),
    Dropout(0.2),
    LSTM(50, return_sequences=False),
    Dropout(0.2),
    Dense(25),
    Dense(1)
])

model.compile(optimizer='adam', loss='mean_squared_error')
model.fit(X_train, y_train, epochs=20, batch_size=32, validation_data=(X_test, y_test))

# 4. Prediksi 14 Hari dan 1 Tahun ke Depan
def predict_future(model, last_sequence, days):
    future_predictions = []
    current_sequence = last_sequence

    for _ in range(days):
        prediction = model.predict(current_sequence.reshape(1, seq_length, 1))[0]
        future_predictions.append(prediction)
        current_sequence = np.append(current_sequence[1:], prediction).reshape(seq_length, 1)

    return scaler.inverse_transform(np.array(future_predictions).reshape(-1, 1))

last_seq = df_scaled[-seq_length:]
pred_14_days = predict_future(model, last_seq, 14)
pred_1_year = predict_future(model, last_seq, 365)

# 5. Visualisasi Prediksi
plt.figure(figsize=(12,6))
plt.plot(df.index[-100:], df["close"].values[-100:], label="Actual Price")
plt.plot(pd.date_range(df.index[-1], periods=15, freq="D")[1:], pred_14_days, 'g--', label="Predicted (14 Days)")
plt.title("14 Days Price Prediction")
plt.legend()
plt.show()

plt.figure(figsize=(12,6))
plt.plot(df.index, df["close"].values, label="Actual Price")
plt.plot(pd.date_range(df.index[-1], periods=366, freq="D")[1:], pred_1_year, 'g--', label="Predicted (1 Year)")
plt.title("1 Year Price Prediction")
plt.legend()
plt.show()
