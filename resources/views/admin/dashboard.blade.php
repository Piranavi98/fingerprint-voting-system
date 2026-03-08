<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* ========================================
   GLOBAL BACKGROUND
======================================== */
body{
min-height:100vh;
font-family:'Segoe UI',sans-serif;
background:
linear-gradient(rgba(8,18,38,0.92), rgba(8,18,38,0.92)),
url('https://images.unsplash.com/photo-1581093458791-9d15482442f6?auto=format&fit=crop&w=1500&q=80');
background-size:cover;
background-position:center;
color:white;
}

/* ========================================
   NAVBAR
======================================== */
.navbar{
backdrop-filter:blur(16px);
background:rgba(0,0,0,0.7)!important;
border-bottom:1px solid rgba(255,255,255,0.1);
}

.navbar-brand{
font-weight:700;
letter-spacing:.5px;
}

/* ========================================
   PAGE HEADER
======================================== */
.page-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.page-title{
font-size:26px;
font-weight:700;
}

/* ========================================
   GLASS CARD
======================================== */
.glass-card{
border-radius:18px;
background:rgba(255,255,255,0.07);
backdrop-filter:blur(18px);
border:1px solid rgba(255,255,255,0.15);
color:white;
transition:0.35s;
box-shadow:0 10px 25px rgba(0,0,0,0.35);
}

.glass-card:hover{
transform:translateY(-6px);
box-shadow:0 20px 45px rgba(0,0,0,0.55);
}

/* ========================================
   KPI STATS
======================================== */
.stat-number{
font-size:32px;
font-weight:700;
margin-top:5px;
}

/* ========================================
   ICON STYLE
======================================== */
.card-icon{
font-size:42px;
margin-bottom:10px;
}

/* ========================================
   STATUS ALERT
======================================== */
.glass-alert{
background:rgba(255,255,255,0.08);
border-radius:12px;
border:1px solid rgba(255,255,255,0.15);
}

/* ========================================
   CHART CARD
======================================== */
.chart-card{
padding:22px;
}

/* ========================================
   SECTION TITLE
======================================== */
.section-title{
font-size:20px;
font-weight:600;
margin-bottom:15px;
opacity:.9;
}

/* ========================================
   FOOTER
======================================== */
.footer{
opacity:.6;
margin-top:60px;
}

/* ========================================
   MOBILE
======================================== */
@media(max-width:768px){
.page-title{font-size:20px;}
.stat-number{font-size:26px;}
.card-icon{font-size:34px;}
}

</style>
</head>

<body>

<!-- ========================================
 NAVBAR
======================================== -->
<nav class="navbar navbar-dark shadow-sm">
<div class="container-fluid px-4">

<span class="navbar-brand">
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


<div class="container mt-4">

<!-- ========================================
 PAGE HEADER
======================================== -->
<div class="page-header">
<div class="page-title">
<i class="bi bi-speedometer2"></i> Admin Dashboard
</div>
</div>


<!-- ========================================
 SYSTEM STATUS
======================================== -->
<div class="glass-card glass-alert p-3 mb-4">
<i class="bi bi-info-circle-fill me-2"></i>
Election Status:
<strong>
{{ $electionActive ? 'Ongoing' : 'Not Active' }}
</strong>
</div>


<!-- ========================================
 MANAGEMENT MODULES
======================================== -->
<div class="section-title">System Management</div>

<div class="row">

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-primary"><i class="bi bi-person-badge"></i></div>
<h5>Candidates</h5>
<a href="/admin/candidates" class="btn btn-primary btn-sm">Manage</a>
</div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-success"><i class="bi bi-toggle-on"></i></div>
<h5>Elections</h5>
<a href="/admin/elections" class="btn btn-success btn-sm">Manage</a>
</div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-warning"><i class="bi bi-people"></i></div>
<h5>Voters</h5>
<a href="/admin/voters" class="btn btn-warning btn-sm">Manage</a>
</div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-info"><i class="bi bi-bar-chart-line"></i></div>
<h5>Results</h5>
<a href="/admin/results" class="btn btn-info btn-sm">View</a>
</div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-dark"><i class="bi bi-journal-text"></i></div>
<h5>System Logs</h5>
<a href="{{ route('admin.logs') }}" class="btn btn-dark btn-sm">View</a>
</div>
</div>

<div class="col-lg-4 col-md-6 mb-4">
<div class="glass-card text-center p-4">
<div class="card-icon text-secondary"><i class="bi bi-person-plus"></i></div>
<h5>Add Admin</h5>
<a href="{{ route('admin.admins.create') }}" class="btn btn-secondary btn-sm">Add</a>
</div>
</div>

</div>


<!-- ========================================
 BIOMETRIC ANALYTICS
======================================== -->
<hr class="my-5">

<div class="section-title">Biometric Verification Analytics</div>

<div class="row">

<div class="col-md-4 mb-4">
<div class="glass-card text-center p-4">
<div class="text-uppercase small opacity-75">Total Verifications</div>
<div class="stat-number">{{ $totalVerifications }}</div>
</div>
</div>

<div class="col-md-4 mb-4">
<div class="glass-card text-center p-4">
<div class="text-uppercase small opacity-75">Failed Attempts</div>
<div class="stat-number text-danger">{{ $failedAttempts }}</div>
</div>
</div>

</div>


<div class="row mt-3">

<div class="col-md-6 mb-4">
<div class="glass-card chart-card">
<h6 class="mb-3">Verification Success vs Failure</h6>
<canvas id="verificationChart"></canvas>
</div>
</div>

<div class="col-md-6 mb-4">
<div class="glass-card chart-card">
<h6 class="mb-3">Device Usage</h6>
<canvas id="deviceChart"></canvas>
</div>
</div>

</div>

<div class="footer text-center">
© {{ date('Y') }} Secure E-Voting System
</div>
</div>
<!-- ========================================
 CHARTS (UNCHANGED)
======================================== -->
<script>

new Chart(document.getElementById('verificationChart'), {
type:'doughnut',
data:{
labels:['Successful','Failed'],
datasets:[{
data:[{{ $totalVerifications }}, {{ $failedAttempts }}]
}]
}
});

new Chart(document.getElementById('deviceChart'), {
type:'bar',
data:{
labels:[
@foreach($deviceUsage as $device)
'{{ $device->device_used }}',
@endforeach
],
datasets:[{
label:'Usage Count',
data:[
@foreach($deviceUsage as $device)
{{ $device->total }},
@endforeach
]
}]
}
});

</script>

</body>
</html>