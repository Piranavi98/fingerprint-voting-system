<!DOCTYPE html>
<html>
<head>
    <title>Election Management</title>

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
   GLASS CARD
=============================== */
.glass-card{
    border-radius:18px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,0.15);
}

/* ===============================
   TABLE
=============================== */
.table{
    color:white;
}

.table thead{
    background:rgba(255,255,255,0.15);
}

.table-hover tbody tr:hover{
    background:rgba(255,255,255,0.08);
}

/* ===============================
   BADGES
=============================== */
.status-badge{
    padding:6px 12px;
    font-size:13px;
    border-radius:8px;
}

/* ===============================
   BUTTONS
=============================== */
.btn{
    border-radius:10px;
}

/* ===============================
   ACTION BUTTON GROUP
=============================== */
.action-btns .btn{
    margin:2px;
}

</style>
</head>

<body>

<div class="container mt-5">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
<i class="bi bi-calendar-event"></i>
Election Management
</h2>

<div>
<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
<i class="bi bi-arrow-left"></i> Dashboard
</a>

<a href="/admin/elections/create" class="btn btn-primary">
<i class="bi bi-plus-lg"></i> Add Election
</a>
</div>

</div>


<!-- ===============================
   GLASS TABLE CARD
=============================== -->
<div class="glass-card p-4">

<div class="table-responsive">

<table class="table table-bordered table-hover text-center align-middle">

<thead>
<tr>
<th>#</th>
<th>Title</th>
<th>Start Date</th>
<th>End Date</th>
<th>Status</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($elections as $election)

<tr>

<td>{{ $loop->iteration }}</td>
<td class="fw-semibold">{{ $election->title }}</td>
<td>{{ $election->start_date }}</td>
<td>{{ $election->end_date }}</td>

<td>
@if($election->active)
<span class="badge bg-success status-badge">
<i class="bi bi-play-circle"></i> Ongoing
</span>
@else
<span class="badge bg-secondary status-badge">
<i class="bi bi-stop-circle"></i> Not Active
</span>
@endif
</td>


<td class="action-btns">

<a href="/admin/elections/edit/{{ $election->id }}"
   class="btn btn-warning btn-sm">
   <i class="bi bi-pencil-square"></i>
</a>

<a href="/admin/elections/delete/{{ $election->id }}"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Delete this election?')">
   <i class="bi bi-trash"></i>
</a>

<a href="{{ route('admin.elections.toggle', $election->id) }}"
   class="btn btn-sm btn-{{ $election->active ? 'danger' : 'success' }}">
   <i class="bi {{ $election->active ? 'bi-stop-circle' : 'bi-play-circle' }}"></i>
</a>

</td>

</tr>

@endforeach

</tbody>
</table>

</div>

</div>

</div>

</body>
</html>
