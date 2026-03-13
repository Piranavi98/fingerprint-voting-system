<!DOCTYPE html>
<html>
<head>

<title>Vote Receipt</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* =========================================
   BACKGROUND (BIOMETRIC SECURITY STYLE)
========================================= */
body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:
linear-gradient(rgba(6,15,35,0.92),rgba(6,15,35,0.92)),
url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1600&q=80');

background-size:cover;
background-position:center;
background-attachment:fixed;

color:white;
font-family:'Segoe UI',sans-serif;
}


/* =========================================
   RECEIPT CARD
========================================= */
.receipt-card{

background:rgba(255,255,255,0.07);

backdrop-filter:blur(18px);

padding:45px;

border-radius:22px;

text-align:center;

max-width:430px;

border:1px solid rgba(255,255,255,0.18);

box-shadow:
0 20px 50px rgba(0,0,0,0.6),
inset 0 0 25px rgba(255,255,255,0.03);

transition:all .3s ease;
}

.receipt-card:hover{

transform:translateY(-5px);

box-shadow:
0 30px 70px rgba(0,0,0,0.7),
0 0 20px rgba(0,255,200,0.25);
}


/* =========================================
   SUCCESS CHECK ICON
========================================= */
.check{

font-size:80px;

color:#00ff9c;

margin-bottom:18px;

text-shadow:0 0 15px rgba(0,255,156,0.6);

animation:pulse 1.5s infinite;
}


/* =========================================
   TITLE
========================================= */
h3{

font-weight:700;

letter-spacing:.5px;

margin-bottom:10px;
}


/* =========================================
   DIVIDER
========================================= */
hr{

border-color:rgba(255,255,255,0.2);

margin:20px 0;
}


/* =========================================
   TEXT STYLE
========================================= */
p{

font-size:15px;

opacity:.9;

margin-bottom:8px;
}


/* =========================================
   BUTTON
========================================= */
.btn-success{

background:linear-gradient(135deg,#00c853,#00e676);

border:none;

padding:10px 22px;

font-weight:600;

transition:.3s;
}

.btn-success:hover{

transform:scale(1.06);

box-shadow:0 10px 25px rgba(0,255,150,0.4);
}


/* =========================================
   ANIMATION
========================================= */
@keyframes pulse{

0%{ transform:scale(1); opacity:1; }

50%{ transform:scale(1.08); opacity:0.85; }

100%{ transform:scale(1); opacity:1; }

}


/* =========================================
   MOBILE
========================================= */
@media(max-width:768px){

.receipt-card{

padding:35px;

max-width:90%;

}

.check{

font-size:65px;

}

}

</style>

</head>

<body>

<div class="receipt-card">

<div class="check">✔</div>

<h3>Vote Submitted Successfully</h3>

<hr>

<p><strong>Election:</strong> {{ session('election') }}</p>

<p><strong>Candidate:</strong> {{ session('candidate') }}</p>

<p><strong>Time:</strong> {{ session('time') }}</p>

<a href="{{ route('voter.dashboard') }}" class="btn btn-success mt-3">
Return to Dashboard
</a>

</div>

</body>
</html>