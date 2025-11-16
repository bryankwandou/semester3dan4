import nltk
from nltk.corpus import stopwords
from sklearn.feature_extraction.text import TfidfVectorizer

# Contoh tokenisasi
nltk.download('punkt')
text = "Harga emas naik karena ketegangan geopolitik meningkat."
tokens = nltk.word_tokenize(text)
print(tokens)

# Stopword Removal
nltk.download('stopwords')
stop_words = set(stopwords.words('indonesian'))
filtered_tokens = [word for word in tokens if word.lower() not in stop_words]
print(filtered_tokens)
