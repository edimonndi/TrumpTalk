import re
from collections import Counter

def analyze():
    # Read text
    with open('speeches.txt', 'r', encoding='utf-8') as f:
        text = f.read()

    # Clean text
    text = re.sub(r'SPEECH \d+', '', text)
    text = re.sub(r'TRUMP:', '', text)
    text = re.sub(r'\(Laughter\)', '', text)
    text = re.sub(r'\(Applause\)', '', text)
    text = re.sub(r'\[.*?\]', '', text)
    
    # 1. Most used sentences
    # Split by common sentence terminators (. ! ?)
    sentences_raw = re.split(r'[.!?]+', text)
    sentences = [s.strip() for s in sentences_raw if len(s.strip().split()) > 2]
    
    # Let's clean the sentences a bit (lowercase, remove punctuation at the end)
    cleaned_sentences = [re.sub(r'[^a-zA-Z0-9\s\']', '', s.strip().lower()) for s in sentences]
    # Filter very short sentences
    cleaned_sentences = [s for s in cleaned_sentences if len(s.split()) > 2]
    
    sentence_counts = Counter(cleaned_sentences)
    
    # 2. Most used words (excluding basic stop words)
    words = re.findall(r'\b[a-zA-Z\']+\b', text.lower())
    stop_words = {'the', 'and', 'to', 'of', 'a', 'in', 'that', 'i', 'is', 'it', 'we', 'they', 'you', 'are', 'for', 'on', 'this', 'have', 'with', 'was', 'as', 'at', 'but', 'not', 'be', 'my', 'he', 'by', 'do', 'about', 'our', 'what', 'so', 'me', 'all', 'out', 'up', 'been', 'can', 'has', 'will', 'there', 'who', 'if', 'them', 'from', 'when', 'would', 'their', 'were', 'which', 'or', 'an', 'no', 'just', 'like', 'it\'s', 'we\'re', 'they\'re', 'i\'m', 'don\'t', 'that\'s', 'he\'s', 'i\'ve', 'you\'re'}
    filtered_words = [w for w in words if w not in stop_words and len(w) > 2]
    word_counts = Counter(filtered_words)
    
    # 3. N-grams (phrases like 3 or 4 words)
    words_for_ngrams = [w for w in words if w not in {'the', 'and', 'to', 'of', 'a', 'in', 'i', 'it'}]
    n = 3
    trigrams = zip(*[words_for_ngrams[i:] for i in range(n)])
    trigrams_list = [" ".join(trigram) for trigram in trigrams]
    trigram_counts = Counter(trigrams_list)

    n = 4
    quadgrams = zip(*[words_for_ngrams[i:] for i in range(n)])
    quadgrams_list = [" ".join(quadgram) for quadgram in quadgrams]
    quadgram_counts = Counter(quadgrams_list)

    print("=== TOP 20 WORDS ===")
    for w, c in word_counts.most_common(20):
        print(f"{c}: {w}")

    print("\n=== TOP 20 SENTENCES ===")
    for s, c in sentence_counts.most_common(20):
        print(f"{c}: {s}")
        
    print("\n=== TOP 20 TRIGRAMS ===")
    for tg, c in trigram_counts.most_common(20):
        print(f"{c}: {tg}")

    print("\n=== TOP 20 QUADGRAMS ===")
    for qg, c in quadgram_counts.most_common(20):
        print(f"{c}: {qg}")

if __name__ == '__main__':
    analyze()
