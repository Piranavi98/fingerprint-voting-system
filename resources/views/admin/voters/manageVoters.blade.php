<!DOCTYPE html>
<html>
<head>
    <title>Manage Voters</title>

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
    margin-bottom:20px;
}

/* ===============================
   GLASS CARD
=============================== */
.glass-card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border-radius:18px;
    padding:25px;
    box-shadow:0 20px 40px rgba(0,0,0,0.35);
}

/* ===============================
   TABLE
=============================== */
.glass-table{
    border-radius:12px;
    overflow:hidden;
}

/* header */
.glass-table thead th{
    background:rgba(0,0,0,0.55);
    color:white;
    border:none;
}

/* ⭐ FIXED — visible text */
.glass-table tbody tr{
    background:rgba(255,255,255,0.9);
}

.glass-table td{
    color:#1f2937;
    font-weight:500;
}

/* ===============================
   STATUS BADGES
=============================== */
.badge{
    padding:6px 10px;
    border-radius:8px;
}

/* ===============================
   ACTION BUTTONS
=============================== */
.action-btns .btn{
    margin-right:6px;
    border-radius:8px;
}

/* ===============================
   MOBILE
=============================== */
@media(max-width:768px){
    .page-header{
        flex-direction:column;
        gap:10px;
        align-items:flex-start;
    }
}

</style>
</head>

<body>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="page-header">
        <h3><i class="bi bi-people"></i> Manage Voters</h3>

        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light me-2">
                ← Dashboard
            </a>

            <a href="{{ route('register') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Add Voter
            </a>
        </div>
    </div>

    <!-- GLASS CARD -->
    <div class="glass-card">

        <table class="table text-center align-middle glass-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Fingerprint</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($voters as $voter)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $voter->name }}</td>

                    <td>{{ $voter->email }}</td>

                    <!-- Fingerprint -->
                    <td>
                        @if($voter->fingerprint_verified)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-danger">Not Verified</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td>
                        @if($voter->status ?? true)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="action-btns">

                        <a href="/admin/voters/edit/{{ $voter->id }}"
                           class="btn btn-warning btn-sm">
                           <i class="bi bi-pencil"></i>
                        </a>

                        <a href="/admin/voters/delete/{{ $voter->id }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this voter?')">
                           <i class="bi bi-trash"></i>
                        </a>

                        @if(!$voter->fingerprint_verified)
                        <a href="/admin/voters/verify/{{ $voter->id }}"
                           class="btn btn-success btn-sm">
                           <i class="bi bi-check-circle"></i>
                        </a>
                        @endif

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
