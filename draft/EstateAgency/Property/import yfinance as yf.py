import yfinance as yf

# Ambil data EUR/USD dari Yahoo Finance
df = yf.download("EURUSD=X", start="2023-01-01", end="2024-03-15")

# Simpan ke file CSV
df.to_csv("data_harga.csv")

print("File data_harga.csv berhasil dibuat!")
