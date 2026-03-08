import joblib

# ===============================
# LOAD TRAINED MODEL
# ===============================
model = joblib.load("keystroke_model.pkl")

print("Model loaded successfully")

# ===============================
# TEST TYPING SAMPLE
# Replace with real values later
# ===============================
sample_typing = [
    95, 80, 110, 75, 90, 85, 70, 100, 92, 88,
    76, 83, 79, 91, 87, 82, 77, 96, 89, 84
]

# Model expects 2D array
prediction = model.predict([sample_typing])

# ===============================
# RESULT
# ===============================
if prediction[0] == 1:
    print("✅ Normal typing — AUTHENTIC USER")
else:
    print("❌ Abnormal typing — POSSIBLE INTRUDER")
