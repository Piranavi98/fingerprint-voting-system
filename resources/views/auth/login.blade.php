<!DOCTYPE html>
<html>
<head>
    <title>Secure Biometric Voting Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ================= BACKGROUND ================= */
body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Segoe UI',sans-serif;
    background:url('https://t4.ftcdn.net/jpg/11/02/20/51/360_F_1102205192_KhLTPYHftzFpWM9uxwITG4MBaq2HgNTZ.jpg') no-repeat center center;
    background-size:cover;
    position:relative;
}

/* dark overlay */
body::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(135deg,rgba(0,0,0,0.75),rgba(0,0,0,0.55));
}

/* ================= GLASS CARD ================= */
.login-card{
    position:relative;
    backdrop-filter:blur(16px);
    background:rgba(255,255,255,0.12);
    border-radius:22px;
    padding:40px;
    width:100%;
    max-width:420px;
    color:white;
    box-shadow:0 25px 60px rgba(0,0,0,0.5);
    border:1px solid rgba(255,255,255,0.2);
}

/* ================= INPUT ================= */
.form-control{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
    border-radius:12px;
    padding-left:45px;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

.form-control:focus{
    background:rgba(255,255,255,0.25);
    color:white;
    box-shadow:none;
}

/* ================= ICON INPUT ================= */
.icon-input{ position:relative; }

.icon-input i{
    position:absolute;
    top:50%;
    left:14px;
    transform:translateY(-50%);
    color:white;
}

.toggle-password{
    right:14px;
    left:auto;
    cursor:pointer;
}

/* ================= BUTTONS ================= */
.btn-login{
    background:linear-gradient(90deg,#00c6ff,#0072ff);
    border:none;
    font-weight:600;
    border-radius:12px;
    padding:12px;
}

.btn-login:hover{ opacity:0.9; }

.btn-bio{
    background:rgba(255,255,255,0.15);
    border:1px solid rgba(255,255,255,0.3);
    color:white;
    border-radius:12px;
}

.btn-bio:hover{ background:rgba(255,255,255,0.25); }

.spinner-border{ display:none; }

.footer-text{
    font-size:13px;
    color:rgba(255,255,255,0.7);
}

</style>
</head>

<body>

<div class="login-card text-center">

    <div style="font-size:50px">🗳</div>
    <h3 class="fw-bold">Secure E-Voting</h3>
    <div class="mb-4" style="font-size:12px;color:#9be7ff">
        Biometric Identity Verification Portal
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- LOGIN FORM -->
    <form method="POST" action="{{ route('login') }}" id="loginForm" onsubmit="showLoader()">
        @csrf

        <!-- ⭐ Hidden field for AI typing data -->
        <input type="hidden" name="typing_pattern" id="typing_pattern">

        <div class="mb-3 icon-input">
            <i class="bi bi-envelope-fill"></i>
            <input type="email" name="email" class="form-control"
                   placeholder="Email address" required autofocus>
        </div>

        <div class="mb-3 icon-input">
            <i class="bi bi-lock-fill"></i>
            <input type="password" id="password" name="password"
                   class="form-control" placeholder="Password" required>
            <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
        </div>

        <button type="submit" class="btn btn-login w-100 mb-3">
            Login Securely
        </button>

        <div class="spinner-border text-light" id="loader"></div>
    </form>

    <button class="btn btn-bio w-100 mt-2">
        <i class="bi bi-fingerprint"></i>
        Login with Fingerprint
    </button>

    <p class="mt-3 footer-text">
        Government Certified Biometric Authentication
    </p>

</div>

<script>
function togglePassword(){
    const input=document.getElementById('password');
    const icon=document.querySelector('.toggle-password');

    if(input.type==='password'){
        input.type='text';
        icon.classList.replace('bi-eye','bi-eye-slash');
    }else{
        input.type='password';
        icon.classList.replace('bi-eye-slash','bi-eye');
    }
}
function showLoader(){
    document.getElementById('loader').style.display='inline-block';
}
document.addEventListener("DOMContentLoaded", function(){

let keyDownTimes = {};
let holdTimes = [];

const passwordField = document.getElementById("password");

passwordField.addEventListener("keydown", function(e){
    keyDownTimes[e.key] = performance.now();
});

passwordField.addEventListener("keyup", function(e){
    if(keyDownTimes[e.key]){
        let hold = performance.now() - keyDownTimes[e.key];
        holdTimes.push(Math.round(hold));
        delete keyDownTimes[e.key];
    }
});

document.getElementById("loginForm").addEventListener("submit", function(){
    document.getElementById("typing_pattern").value =
        JSON.stringify(holdTimes);
});
});
</script>

</body>
</html>