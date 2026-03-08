<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Candidate</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===============================
   BACKGROUND
=============================== */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:
    linear-gradient(rgba(10,20,40,0.8),rgba(10,20,40,0.8)),
    url('https://images.unsplash.com/photo-1581093458791-9d15482442f6?auto=format&fit=crop&w=1500&q=80');
    background-size:cover;
    background-position:center;
    color:white;
}

/* ===============================
   GLASS CARD
=============================== */
.glass-card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border-radius:18px;
    border:1px solid rgba(255,255,255,0.2);
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,0.4);
}

/* ===============================
   TITLE
=============================== */
.page-title{
    font-weight:700;
}

/* ===============================
   FORM
=============================== */
.form-control,
.form-select{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
    border-radius:10px;
}

.form-control:focus,
.form-select:focus{
    background:rgba(255,255,255,0.25);
    color:white;
    box-shadow:none;
}

.form-control::placeholder{
    color:rgba(255,255,255,0.7);
}

/* ===============================
   IMAGE PREVIEW
=============================== */
.img-preview{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:12px;
    border:2px solid rgba(255,255,255,0.3);
}

/* ===============================
   BUTTONS
=============================== */
.btn-primary{
    background:linear-gradient(90deg,#00c6ff,#0072ff);
    border:none;
    border-radius:10px;
    font-weight:600;
}

.btn-secondary{
    border-radius:10px;
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

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">✏️ Edit Candidate</h2>

        <a href="/admin/candidates" class="btn btn-outline-light">
            ← Back
        </a>
    </div>

    <div class="glass-card">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('candidates.update', $candidate->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <label class="form-label">Candidate Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $candidate->name) }}"
                       class="form-control"
                       required>
            </div>

            <!-- PARTY -->
            <div class="mb-3">
                <label class="form-label">Party / Position</label>
                <input type="text"
                       name="party"
                       value="{{ old('party', $candidate->party) }}"
                       class="form-control"
                       required>
            </div>

            <!-- ELECTION -->
            <div class="mb-3">
                <label class="form-label">Select Election</label>
                <select name="election_id" class="form-select" required>
                    @foreach($elections as $election)
                        <option value="{{ $election->id }}"
                        {{ $candidate->election_id == $election->id ? 'selected' : '' }}>
                            {{ $election->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- IMAGE -->
            <div class="mb-3">
                <label class="form-label">Candidate Photo</label>
                <input type="file" name="image" class="form-control">

                @if($candidate->image)
                    <div class="mt-3">
                        <img src="{{ asset('uploads/candidates/'.$candidate->image) }}"
                             class="img-preview">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">
                Update Candidate
            </button>

        </form>

    </div>
</div>

</body>
</html>
