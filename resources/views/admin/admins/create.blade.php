<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ===============================
   BACKGROUND
=============================== */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
    linear-gradient(rgba(10,20,40,0.85),rgba(10,20,40,0.85)),
    url('https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=1500&q=80');
    background-size:cover;
    background-position:center;
    color:white;
}

/* ===============================
   PAGE HEADER
=============================== */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

/* ===============================
   GLASS CARD
=============================== */
.glass-card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border-radius:20px;
    padding:30px;
    box-shadow:0 20px 45px rgba(0,0,0,0.35);
}

/* ===============================
   INPUTS
=============================== */
.form-control{
    background:rgba(255,255,255,0.12);
    border:none;
    border-radius:10px;
    color:white;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

.form-control:focus{
    background:rgba(255,255,255,0.2);
    color:white;
    box-shadow:none;
}

/* ===============================
   BUTTONS
=============================== */
.btn{
    border-radius:10px;
    padding:10px 18px;
    font-weight:500;
}

/* ===============================
   MOBILE
=============================== */
@media(max-width:768px){
    .page-header{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
    }
}

</style>
</head>

<body>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="page-header">
        <h3><i class="bi bi-person-plus"></i> Add New Admin</h3>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
            ← Back to Dashboard
        </a>
    </div>

    <!-- GLASS CARD -->
    <div class="glass-card">

        <form method="POST" action="{{ route('admin.admins.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Enter full name"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter email"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter password"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Confirm password"
                       required>
            </div>

            <input type="hidden" name="role" value="admin">

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-shield-check"></i>
                Create Admin Account
            </button>

        </form>

    </div>

</div>

</body>
</html>
