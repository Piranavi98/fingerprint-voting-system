<!DOCTYPE html>
<html>
<head>
    <title>Create Election</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    padding:30px;
}

/* ===============================
   INPUT STYLE
=============================== */
.form-control{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
    border-radius:10px;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

.form-control:focus{
    background:rgba(255,255,255,0.25);
    color:white;
    box-shadow:none;
}

/* ===============================
   BUTTON
=============================== */
.btn-primary{
    border-radius:10px;
    font-weight:500;
}

/* ===============================
   TITLE
=============================== */
.page-title{
    font-weight:700;
}

</style>

</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Create New Election</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/elections/store" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Election Title</label>
            <input type="text" name="title" class="form-control" placeholder="Eg: School Election 2025" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description (Optional)</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Create Election</button>
    </form>
</div>

</body>
</html>
