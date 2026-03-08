<!DOCTYPE html>
<html>
<head>
    <title>Secure Biometric Registration</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ===== BACKGROUND IMAGE ===== */
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

/* ===== GLASS CARD ===== */
.register-card{
    position:relative;
    backdrop-filter:blur(14px);
    background:rgba(255,255,255,0.12);
    border-radius:20px;
    padding:40px;
    width:100%;
    max-width:420px;
    color:white;
    box-shadow:0 25px 60px rgba(0,0,0,0.5);
    border:1px solid rgba(255,255,255,0.2);
}

/* ===== INPUT ===== */
.form-control, .form-select{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
    border-radius:12px;
    padding-left:45px;
}

.form-select{
    padding-left:15px;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

.form-control:focus, .form-select:focus{
    background:rgba(255,255,255,0.25);
    color:white;
    box-shadow:none;
}

/* ===== ICON INPUT ===== */
.icon-input{
    position:relative;
}

.icon-input i{
    position:absolute;
    top:50%;
    left:14px;
    transform:translateY(-50%);
    color:white;
}

/* ===== BUTTON ===== */
.btn-register{
    background:linear-gradient(90deg,#00c6ff,#0072ff);
    border:none;
    font-weight:600;
    border-radius:12px;
    padding:12px;
}

.btn-register:hover{
    opacity:0.9;
}

.footer-text{
    font-size:13px;
    color:rgba(255,255,255,0.7);
}

</style>
</head>

<body>

<div class="register-card text-center">

    <div style="font-size:50px">🗳</div>
    <h3 class="fw-bold">Create Secure Account</h3>
    <div class="mb-4" style="font-size:12px;color:#9be7ff">
        Biometric Identity Registration Portal
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAME -->
        <div class="mb-3 icon-input">
            <i class="bi bi-person-fill"></i>
            <input type="text" name="name" class="form-control"
                   placeholder="Full Name" required>
        </div>

        <!-- EMAIL -->
        <div class="mb-3 icon-input">
            <i class="bi bi-envelope-fill"></i>
            <input type="email" name="email" class="form-control"
                   placeholder="Email address" required>
        </div>

        <!-- PASSWORD -->
        <div class="mb-3 icon-input">
            <i class="bi bi-lock-fill"></i>
            <input type="password" name="password"
                   class="form-control"
                   placeholder="Password" required>
        </div>

        <!-- CONFIRM -->
        <div class="mb-3 icon-input">
            <i class="bi bi-shield-lock-fill"></i>
            <input type="password" name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm Password" required>
        </div>

        <!-- ROLE -->
        <div class="mb-3">
            <select name="role" class="form-select">
                <option value="voter">Register as Voter</option>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <option value="admin">Register as Admin</option>
                @endif
            </select>
        </div>

        <button type="submit" class="btn btn-register w-100 mb-3">
            <i class="bi bi-person-plus me-1"></i>
            Register Securely
        </button>

    </form>

    <p class="footer-text mt-2">
        Already registered?
        <a href="{{ route('login') }}" style="color:#9be7ff;text-decoration:none;">
            Login here
        </a>
    </p>

    <p class="footer-text mt-2">
        Government Certified Biometric System
    </p>

</div>

</body>
</html>
