<!DOCTYPE html>
<html>
<head>
    <title>Add Candidate</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ===============================
   BACKGROUND
=============================== */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
    linear-gradient(rgba(10,20,40,0.85), rgba(10,20,40,0.85)),
    url('https://images.unsplash.com/photo-1581093458791-9d15482442f6?auto=format&fit=crop&w=1500&q=80');
    background-size:cover;
    background-position:center;
    color:white;
}

/* ===============================
   NAVBAR
=============================== */
.navbar{
    backdrop-filter:blur(12px);
    background:rgba(0,0,0,0.65)!important;
}

/* ===============================
   GLASS FORM CARD
=============================== */
.glass-card{
    border-radius:18px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,0.15);
    padding:30px;
}

/* ===============================
   FORM INPUT
=============================== */
.form-control, .form-select{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
    border-radius:10px;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

.form-control:focus, .form-select:focus{
    background:rgba(255,255,255,0.25);
    color:white;
    box-shadow:none;
}

/* ===============================
   BUTTONS
=============================== */
.btn{
    border-radius:10px;
    font-weight:500;
}

/* ===============================
   LABEL
=============================== */
label{
    font-weight:600;
    margin-bottom:6px;
}

/* ===============================
   MOBILE
=============================== */
@media(max-width:768px){
    .glass-card{ padding:20px; }
}

</style>
</head>

<body>

<!-- ===============================
 NAVBAR
=============================== -->
<nav class="navbar navbar-dark shadow-sm">
    <div class="container-fluid px-4">

        <span class="navbar-brand fw-bold">
            <i class="bi bi-shield-lock"></i> Admin Control Center
        </span>

        <div class="d-flex align-items-center">
            <span class="me-3">
                <i class="bi bi-person-circle"></i>
                {{ auth()->user()->name }} (Admin)
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>

    </div>
</nav>


<!-- ===============================
 CONTENT
=============================== -->
<div class="container mt-5">

<div class="col-lg-6 mx-auto">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>
        <i class="bi bi-person-plus"></i> Add Candidate
    </h2>

    <a href="/admin/candidates" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>


<div class="glass-card">

<!-- ERRORS -->
@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="{{ route('admin.candidates.store') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<!-- NAME -->
<div class="mb-3">
<label>Candidate Name</label>
<input type="text"
       name="name"
       class="form-control"
       placeholder="Enter candidate name"
       value="{{ old('name') }}"
       required>
</div>

<!-- POSITION -->
<div class="mb-3">
<label>Party / Position</label>
<input type="text"
       name="party"
       class="form-control"
       placeholder="President / Secretary / etc"
       value="{{ old('party') }}"
       required>
</div>

<!-- ELECTION -->
<div class="mb-3">
<label>Select Election</label>
<select name="election_id" class="form-select" required>
<option value="">-- Select Election --</option>
@foreach($elections as $election)
<option value="{{ $election->id }}"
{{ old('election_id') == $election->id ? 'selected' : '' }}>
{{ $election->title }}
</option>
@endforeach
</select>
</div>

<!-- IMAGE -->
<div class="mb-4">
<label>Candidate Photo</label>
<input type="file" name="image" class="form-control">
</div>

<button type="submit" class="btn btn-primary w-100">
<i class="bi bi-check-circle"></i> Add Candidate
</button>

</form>

</div>
</div>
</div>

</body>
</html>
