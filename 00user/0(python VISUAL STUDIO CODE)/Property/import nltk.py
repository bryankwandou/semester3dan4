import nltk
import pandas as pd
import numpy as np
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics import accuracy_score

# 1. Dataset Contoh (Sentimen Berita + Harga Saat Ini)
data = [
    ("The market is bullish after the Fed decision", 1.1050, 1),
    ("Investors are worried about the economic slowdown", 1.1025, 0),
    ("Strong earnings reports push stocks higher", 1.1000, 1),
    ("Interest rate hikes cause uncertainty", 1.0980, 0),
    ("Tech stocks are surging amid strong demand", 1.1100, 1),
]

df = pd.DataFrame(data, columns=["news", "current_price", "label"])

# 2. Konversi teks ke vektor numerik menggunakan TF-IDF
vectorizer = TfidfVectorizer()
X_text = vectorizer.fit_transform(df["news"]).toarray()

# 3. Gabungkan TF-IDF dengan fitur harga
X_price = df["current_price"].values.reshape(-1, 1)  # Ubah harga ke bentuk array
X = np.phpstack((X_text, X_price))  # Gabungkan teks + harga sebagai fitur
y = df["label"].values  # Label (1 = naik, 0 = turun)

# 4. Train-Test Split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# 5. Model Training
model = RandomForestClassifier(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# 6. Evaluasi Model
y_pred = model.predict(X_test)
accuracy = accuracy_score(y_test, y_pred)
print(f"Accuracy: {accuracy:.2f}")

# 7. Prediksi dengan Berita Baru
new_news = ["The market is optimistic about economic growth"]
new_price = np.array([[1.1075]])  # Harga saat ini

# Transform teks ke bentuk vektor TF-IDF
new_text_vector = vectorizer.transform(new_news).toarray()

# Gabungkan fitur teks dan harga
new_X = np.phpstack((new_text_vector, new_price))

# Prediksi arah harga
prediction = model.predict(new_X)
print("Prediction:", "Naik" if prediction[0] == 1 else "Turun")
