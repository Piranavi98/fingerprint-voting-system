<!DOCTYPE html>
<html>
<head>
    <title>Manage Candidates</title>

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
   GLASS CARD
=============================== */
.glass-card{
    border-radius:18px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,0.15);
    color:white;
}

/* ===============================
   TABLE
=============================== */
.table{
    color:white;
}

.table thead{
    background:rgba(255,255,255,0.12);
}

.table tbody tr{
    border-color:rgba(255,255,255,0.1);
}

.table-hover tbody tr:hover{
    background:rgba(255,255,255,0.06);
}

/* ===============================
   CANDIDATE IMAGE
=============================== */
.candidate-img{
    width:55px;
    height:55px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid rgba(255,255,255,0.3);
}

/* ===============================
   BUTTONS
=============================== */
.btn{
    border-radius:10px;
}

/* ===============================
   MOBILE
=============================== */
@media(max-width:768px){
    h2{font-size:20px;}
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
<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>
        <i class="bi bi-person-badge"></i> Candidate Management
    </h2>

    <a href="/admin/candidates/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Candidate
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<!-- ===============================
 TABLE CARD
=============================== -->
<div class="glass-card p-3">

<div class="table-responsive">

<table class="table table-hover text-center align-middle">

<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Position</th>
<th>Photo</th>
<th>Election</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($candidates as $candidate)
<tr>

<td>{{ $loop->iteration }}</td>

<td class="fw-semibold">{{ $candidate->name }}</td>

<td>{{ $candidate->party }}</td>

<td>
@if($candidate->image)
<img src="{{ asset('uploads/candidates/'.$candidate->image) }}"
     class="candidate-img">
@else
<span class="text-light opacity-75">No Image</span>
@endif
</td>

<td>{{ $candidate->election->title ?? 'N/A' }}</td>

<td>

<a href="/admin/candidates/edit/{{ $candidate->id }}"
   class="btn btn-warning btn-sm">
   <i class="bi bi-pencil"></i>
</a>

<a href="/admin/candidates/delete/{{ $candidate->id }}"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this candidate?')">
   <i class="bi bi-trash"></i>
</a>

</td>

</tr>
@empty

<tr>
<td colspan="6" class="opacity-75">No candidates found</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>


<!-- BACK BUTTON -->
<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light mt-3">
<i class="bi bi-arrow-left"></i> Back to Dashboard
</a>

</div>

</body>
</html>
