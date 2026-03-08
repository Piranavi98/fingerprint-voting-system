from flask import Flask, request, jsonify
import joblib

# =========================
# LOAD TRAINED MODEL
# =========================
model = joblib.load("keystroke_model.pkl")

# =========================
# CREATE APP
# =========================
app = Flask(__name__)

# =========================
# PREDICT ENDPOINT
# =========================
@app.route("/predict", methods=["POST"])
def predict():

    data = request.get_json()

    if not data or "typing_pattern" not in data:
        return jsonify({"error": "Missing typing data"}), 400

    typing_pattern = data["typing_pattern"]

    prediction = model.predict([typing_pattern])[0]

    if prediction == 1:
        result = "normal"
    else:
        result = "intruder"

    return jsonify({
        "result": result
    })

# =========================
# RUN SERVER
# =========================
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)
