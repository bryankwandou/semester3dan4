# Contoh implementasi final yang aman
import pandas as pd

def load_data(filepath):
    # Baca tanpa parse_dates dulu
    temp_df = pd.read_csv(filepath, nrows=5)
    print("Kolom tersedia:", temp_df.columns)
    
    # Cari kolom tanggal dengan regex
    date_cols = [col for col in temp_df.columns if 'date' in col.lower()]
    
    # Baca ulang dengan parse_dates
    return pd.read_csv(
        filepath,
        parse_dates=date_cols,
        infer_datetime_format=True
    )
