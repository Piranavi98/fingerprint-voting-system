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
   GLOBAL BACKGROUND (CYBER SECURITY STYLE)
======================================== */
body{
min-height:100vh;
font-family:'Segoe UI',sans-serif;

background:
linear-gradient(rgba(6,14,32,0.95), rgba(6,14,32,0.95)),
url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1600&q=80');

background-size:cover;
background-position:center;
background-attachment:fixed;

color:white;
}


/* ========================================
   NAVBAR
======================================== */
.navbar{
backdrop-filter:blur(18px);
background:rgba(0,0,0,0.65)!important;
border-bottom:1px solid rgba(255,255,255,0.1);
}

.navbar-brand{
font-weight:700;
letter-spacing:.7px;
font-size:18px;
}


/* ========================================
   PAGE HEADER
======================================== */
.page-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.page-title{
font-size:26px;
font-weight:700;
letter-spacing:.5px;
}


/* ========================================
   GLASS CARD (PREMIUM STYLE)
======================================== */
.glass-card{
border-radius:18px;

background:rgba(255,255,255,0.07);

backdrop-filter:blur(20px);

border:1px solid rgba(255,255,255,0.15);

color:white;

transition:all 0.35s ease;

box-shadow:
0 12px 30px rgba(0,0,0,0.45),
inset 0 0 20px rgba(255,255,255,0.03);
}

.glass-card:hover{

transform:translateY(-8px) scale(1.02);

box-shadow:
0 25px 60px rgba(0,0,0,0.7),
0 0 25px rgba(0,255,200,0.25);
}


/* ========================================
   KPI STATS
======================================== */
.stat-number{
font-size:34px;
font-weight:700;
margin-top:8px;
letter-spacing:.5px;
}


/* ========================================
   ICON STYLE
======================================== */
.card-icon{
font-size:44px;
margin-bottom:12px;
text-shadow:0 0 12px rgba(255,255,255,0.35);
}


/* ========================================
   STATUS ALERT
======================================== */
.glass-alert{

background:rgba(255,255,255,0.08);

border-radius:12px;

border:1px solid rgba(255,255,255,0.15);

backdrop-filter:blur(10px);

font-size:15px;
}


/* ========================================
   CHART CARD
======================================== */
.chart-card{
padding:24px;
}


/* ========================================
   SECTION TITLE
======================================== */
.section-title{
font-size:20px;
font-weight:600;
margin-bottom:18px;
opacity:.9;
letter-spacing:.4px;
}


/* ========================================
   BUTTON STYLE
======================================== */
.btn-primary{
background:linear-gradient(135deg,#007bff,#00c6ff);
border:none;
}

.btn-success{
background:linear-gradient(135deg,#00c853,#00e676);
border:none;
}

.btn-warning{
background:linear-gradient(135deg,#ff9800,#ffc107);
border:none;
}

.btn-info{
background:linear-gradient(135deg,#00bcd4,#00e5ff);
border:none;
}

.btn-dark{
background:linear-gradient(135deg,#343a40,#212529);
border:none;
}

.btn-secondary{
background:linear-gradient(135deg,#6c757d,#495057);
border:none;
}

.btn:hover{
transform:scale(1.05);
transition:.25s;
}


/* ========================================
   CHART CANVAS IMPROVEMENT
======================================== */
canvas{
max-height:260px;
}


/* ========================================
   FOOTER
======================================== */
.footer{
opacity:.65;
margin-top:60px;
font-size:14px;
}


/* ========================================
   MOBILE
======================================== */
@media(max-width:768px){

.page-title{font-size:21px;}

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