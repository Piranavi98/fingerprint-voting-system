import pandas as pd
import json
from sklearn.ensemble import IsolationForest
import joblib

# ===============================
# LOAD CSV EXPORTED FROM DATABASE
# ===============================
data = pd.read_csv("keystrokes.csv")

print("Dataset loaded:", len(data), "rows")

# ===============================
# CONVERT JSON → HOLD TIMES
# ===============================
features = []

for pattern in data["typing_pattern"]:
    try:
        keys = json.loads(pattern)

        holds = [k["hold"] for k in keys]

        # Pad or trim to fixed length (20 keys)
        if len(holds) < 20:
            holds += [0] * (20 - len(holds))
        else:
            holds = holds[:20]

        features.append(holds)

    except:
        continue

print("Valid typing samples:", len(features))

# ===============================
# TRAIN ISOLATION FOREST MODEL
# ===============================
model = IsolationForest(
    n_estimators=100,
    contamination=0.1,
    random_state=42
)

model.fit(features)

print("Model trained successfully")

# ===============================
# SAVE MODEL
# ===============================
joblib.dump(model, "keystroke_model.pkl")

print("Model saved as keystroke_model.pkl")
