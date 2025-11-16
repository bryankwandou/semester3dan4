import MetaTrader5 as mt5
import pandas as pd
import numpy as np
import mplfinance as mpf
import time
from sklearn.ensemble import RandomForestRegressor
from datetime import datetime

# 1. Koneksi ke MetaTrader 5
mt5.initialize()

symbol = "EURUSD"
timeframe = mt5.TIMEFRAME_M1  # Timeframe 1 menit
num_candles = 100  # Ambil 100 candlestick terakhir

# 2. Fungsi untuk mengambil data candlestick real-time
def get_candlestick_data():
    rates = mt5.copy_rates_from_pos(symbol, timeframe, 0, num_candles)
    df = pd.DataFrame(rates)
    df['time'] = pd.to_datetime(df['time'], unit='s')  # Konversi waktu
    df.set_index('time', inplace=True)
    return df

# 3. Model Prediksi (Random Forest)
def train_model(data):
    X = data[['open', 'high', 'low', 'close', 'tick_volume']].values[:-1]  # Data sebelumnya
    y = data['close'].values[1:]  # Harga close berikutnya
    
    model = RandomForestRegressor(n_estimators=100, random_state=42)
    model.fit(X, y)
    return model

# 4. Fungsi untuk menampilkan candlestick dan prediksi
def plot_candlestick():
    while True:
        df = get_candlestick_data()
        
        # Train model
        model = train_model(df)
        
        # Prediksi candlestick berikutnya
        last_candle = df.iloc[-1][['open', 'high', 'low', 'close', 'tick_volume']].values.reshape(1, -1)
        predicted_price = model.predict(last_candle)[0]
        
        # Tambahkan prediksi ke dataframe
        next_time = df.index[-1] + pd.Timedelta(minutes=1)
        df.loc[next_time] = [df['close'].iloc[-1], predicted_price, predicted_price, predicted_price, df['tick_volume'].iloc[-1]]
        
        # Plot candlestick
        mpf.plot(df, type='candle', style='charles', title=f"Real-Time Candlestick {symbol}",
                 ylabel="Price", volume=True)
        
        print(f"Prediksi harga close berikutnya: {predicted_price:.5f}")
        
        time.sleep(10)  # Update setiap 10 detik

# 5. Jalankan Visualisasi
plot_candlestick()
