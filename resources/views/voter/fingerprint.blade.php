<!DOCTYPE html>
<html>
<head>
    <title>Fingerprint Verification</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===============================
   BACKGROUND
=============================== */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
    linear-gradient(rgba(10,20,40,0.85),rgba(10,20,40,0.85)),
    url('https://images.unsplash.com/photo-1581093458791-9d15482442f6?auto=format&fit=crop&w=1500&q=80');
    background-size:cover;
    background-position:center;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===============================
   GLASS CARD
=============================== */
.verify-card{
    width:100%;
    max-width:500px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border-radius:22px;
    padding:35px;
    box-shadow:0 25px 55px rgba(0,0,0,0.4);
}

/* ===============================
   ICON
=============================== */
.fingerprint-icon{
    font-size:80px;
    margin-bottom:15px;
}

/* ===============================
   ALERTS
=============================== */
.glass-alert{
    background:rgba(255,255,255,0.15);
    border:none;
    border-radius:12px;
    color:white;
}

/* ===============================
   INSTRUCTIONS
=============================== */
.instructions{
    background:rgba(255,255,255,0.08);
    padding:15px;
    border-radius:12px;
}

/* ===============================
   BUTTONS
=============================== */
.btn{
    border-radius:12px;
    padding:12px;
    font-weight:600;
}

.btn-verify{
    background:linear-gradient(90deg,#00c6ff,#0072ff);
    border:none;
}

.btn-verify:hover{
    opacity:0.9;
}

/* ===============================
   MOBILE
=============================== */
@media(max-width:576px){
    .verify-card{
        margin:15px;
        padding:25px;
    }

    .fingerprint-icon{
        font-size:60px;
    }
}

</style>
</head>

<body>

<div class="verify-card text-center">

    <div class="fingerprint-icon">🔐</div>

    <h3 class="fw-bold mb-2">Fingerprint Verification</h3>

    <p style="opacity:0.8">
        To continue with voting, verify your biometric identity using your registered Android device.
    </p>

    <!-- STATUS -->
    @if(session('success'))
        <div class="alert glass-alert mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert glass-alert mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- INSTRUCTIONS -->
    <div class="instructions text-start mt-4 mb-4">
        <strong>Verification Steps:</strong>
        <ol class="mt-2">
            <li>Click the verify button below</li>
            <li>Android app opens automatically</li>
            <li>Place finger on sensor</li>
            <li>Return after success</li>
        </ol>
    </div>

    <!-- BUTTON -->
    @if(auth()->user()->fingerprint_verified)

        <button class="btn btn-success w-100" disabled>
            ✅ Fingerprint Already Verified
        </button>

    @else

        <button onclick="openFingerprintApp()" class="btn btn-verify w-100">
            📱 Verify Fingerprint on Android
        </button>

        <p class="mt-3" style="font-size:13px;opacity:0.7">
            This opens the mobile app and uses your device fingerprint sensor.
        </p>

    @endif

    <a href="/voter/dashboard" class="btn btn-outline-light w-100 mt-3">
        ← Back to Dashboard
    </a>

</div>


<script>
function openFingerprintApp() {
    window.location.href = "voterapp://verify-fingerprint?user_id={{ auth()->id() }}";
}
</script>
<script>

// check every 2 seconds
setInterval(function() {

    fetch('/fingerprint/status')
    .then(response => response.json())
    .then(data => {

        if(data.verified === true) {

            // show message
            document.body.innerHTML = `
                <div style="
                    height:100vh;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:28px;
                    font-weight:bold;
                    color:green;
                ">
                    ✔ Verification Successful<br>
                    Redirecting...
                </div>
            `;

            setTimeout(() => {
                window.location.href = "/voter/dashboard";
            }, 2000);
        }

    });

}, 2000);

</script>
</body>
</html>
