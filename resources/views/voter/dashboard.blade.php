<!DOCTYPE html>
<html>
<head>
    <title>Voter Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

/* ================================
   BACKGROUND (BIOMETRIC STYLE)
================================ */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;

   background:
    linear-gradient(rgba(5,10,25,0.85), rgba(5,10,25,0.85)),
    url('https://img.freepik.com/free-vector/background-fingerprint-neon_23-2148360988.jpg?semt=ais_hybrid&w=740&q=80');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    color:white;
}


/* ================================
   GLASS NAVBAR
================================ */
.glass-navbar{
    background:rgba(0,0,0,0.55);
    backdrop-filter:blur(20px);
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.navbar-brand{
    font-weight:600;
    letter-spacing:1px;
    font-size:18px;
}


/* ================================
   PAGE TITLE
================================ */
.page-title{
    font-weight:700;
    letter-spacing:1px;
}


/* ================================
   GLASS CARD
================================ */
.glass-card{
    border-radius:20px;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.15);

    box-shadow:
        0 10px 30px rgba(0,0,0,0.35),
        inset 0 0 25px rgba(255,255,255,0.04);

    transition:all 0.35s ease;

    height:100%;
}

.glass-card:hover{

    transform:translateY(-8px) scale(1.02);

    box-shadow:
        0 25px 60px rgba(0,0,0,0.6),
        0 0 25px rgba(0,255,200,0.25);
}


/* ================================
   ICON
================================ */
.card-icon{

    font-size:44px;

    margin-bottom:12px;

    text-shadow:0 0 12px rgba(255,255,255,0.4);
}


/* ================================
   TEXT
================================ */
.muted-text{
    opacity:0.85;
    font-size:14px;
}


/* ================================
   STATUS ALERT
================================ */
.status-alert{
    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(15px);

    border-radius:14px;

    border:1px solid rgba(255,255,255,0.2);

    color:white;
}


/* ================================
   BUTTON STYLE
================================ */

.btn-primary{
    background:linear-gradient(135deg,#0066ff,#00c6ff);
    border:none;
}

.btn-success{
    background:linear-gradient(135deg,#00c853,#00e676);
    border:none;
}

.btn-warning{
    background:linear-gradient(135deg,#ff9800,#ffc107);
    border:none;
}

.btn-danger{
    border:none;
}


/* ================================
   SUCCESS OVERLAY
================================ */

#biometricSuccess{

    position:fixed;
    inset:0;

    background:linear-gradient(
        135deg,
        rgba(10,20,40,0.95),
        rgba(5,10,20,0.95)
    );

    backdrop-filter:blur(25px);

    display:flex;
    justify-content:center;
    align-items:center;

    z-index:99999;

    animation:fadeIn 0.4s ease;
}


/* ================================
   SUCCESS CARD
================================ */

.success-card{

    text-align:center;
    color:white;

    padding:55px 45px;

    border-radius:24px;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.25);

    box-shadow:0 40px 90px rgba(0,0,0,0.7);

    max-width:420px;
    width:90%;
}


/* ================================
   SUCCESS CIRCLE
================================ */

.success-circle{

    width:120px;
    height:120px;

    border-radius:50%;

    margin:auto;

    display:flex;
    justify-content:center;
    align-items:center;

    background:linear-gradient(135deg,#00ffb7,#00c3ff);

    box-shadow:0 0 40px rgba(0,255,180,0.6);

    margin-bottom:25px;

    animation:pulse 1.5s infinite;
}

.checkmark{

    font-size:60px;

    font-weight:bold;

    color:white;
}


/* ================================
   PROGRESS BAR
================================ */

.progress-bar{

    width:100%;
    height:6px;

    background:rgba(255,255,255,0.2);

    border-radius:20px;

    overflow:hidden;

    margin-bottom:10px;
}

.progress-fill{

    height:100%;

    width:0%;

    background:linear-gradient(90deg,#00ffb7,#00c3ff);
}


/* ================================
   ANIMATIONS
================================ */

@keyframes fadeIn{

    from{opacity:0}
    to{opacity:1}

}

@keyframes pulse{

    0%{transform:scale(1)}
    50%{transform:scale(1.05)}
    100%{transform:scale(1)}

}


/* ================================
   MOBILE
================================ */

@media(max-width:768px){

    .page-title{
        font-size:22px;
    }

}

</style>
</head>

<body>

<!-- ==============================
     NAVBAR (SAME STYLE)
============================== -->
<nav class="navbar glass-navbar navbar-dark shadow-sm">
    <div class="container-fluid px-4">

        <span class="navbar-brand">
            Secure E-Voting
        </span>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>

        </div>
    </div>
</nav>


<!-- ==============================
     CONTENT
============================== -->
<div class="container py-5">

    <h2 class="page-title mb-4">
        🧑‍💻 Voter Dashboard
    </h2>

    <!-- STATUS -->
    @if(auth()->user()->fingerprint_verified)
        <div class="alert status-alert mb-4">
            <i class="bi bi-check-circle-fill text-success me-2"></i>
            Your fingerprint has been successfully verified.
        </div>
    @else
        <div class="alert status-alert mb-4">
            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
            Fingerprint verification is required before voting.
        </div>
    @endif


    <div class="row g-4">

        <!-- VERIFY -->
        <div class="col-lg-4 col-md-6">
            <div class="glass-card text-center p-4">

                <div class="card-icon text-success">
                    <i class="bi bi-fingerprint"></i>
                </div>

                <h5 class="fw-bold">Fingerprint Verification</h5>

                <p class="muted-text">
                    Verify your biometric identity before voting.
                </p>

                @if(auth()->user()->fingerprint_verified)
                    <button class="btn btn-success">Verified</button>
                @else
                    <a href="/voter/fingerprint" class="btn btn-success">
                        Verify Now
                    </a>
                @endif

            </div>
        </div>


        <!-- CAST VOTE -->
        <div class="col-lg-4 col-md-6">
            <div class="glass-card text-center p-4">

                <div class="card-icon text-info">
                    <i class="bi bi-check2-square"></i>
                </div>

                <h5 class="fw-bold">Cast Your Vote</h5>

                <p class="muted-text">
                    Choose your preferred candidate securely.
                </p>

                @if(auth()->user()->fingerprint_verified)
                    <a href="/voter/vote" class="btn btn-primary">
                        Proceed to Vote
                    </a>
                @else
                    <button class="btn btn-secondary" disabled>
                        Verification Required
                    </button>
                @endif

            </div>
        </div>


        <!-- RESULTS -->
        <div class="col-lg-4 col-md-6">
            <div class="glass-card text-center p-4">

                <div class="card-icon text-warning">
                    <i class="bi bi-bar-chart-line"></i>
                </div>

                <h5 class="fw-bold">Election Results</h5>

                <p class="muted-text">
                    View official election outcomes.
                </p>

              @if($electionActive)

<button class="btn btn-secondary" disabled>
Results Available After Election Ends
</button>

@elseif($endedElection)

<a href="{{ route('voter.results.show',$endedElection->id) }}" class="btn btn-warning">
View Results
</a>

@else

<button class="btn btn-secondary" disabled>
No Results Available
</button>

@endif

            </div>
        </div>

    </div>

</div>
@if(session('fingerprint_success'))

<div id="biometricSuccess">

    <div class="success-card">

        <div class="success-circle">
            <div class="checkmark">✓</div>
        </div>

        <h1>Verification Successful</h1>

        <p>Your biometric identity has been securely verified</p>

        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>

        <small>Redirecting to dashboard...</small>

    </div>

</div>

@endif

@if(session('fingerprint_success'))
<script>
setTimeout(() => {
    document.getElementById('successOverlay').style.display = 'none';
}, 3000);
</script>
@endif

@if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif
</body>
</html>
