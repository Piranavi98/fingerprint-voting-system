<!DOCTYPE html>
<html>
<head>
    <title>System Logs</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===============================
   CYBER SECURITY BACKGROUND
================================ */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;

    background:
    linear-gradient(rgba(5,10,25,0.9),rgba(5,10,25,0.9)),
    url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    color:white;
}


/* ===============================
   PAGE TITLE
================================ */
h2{
    font-weight:700;
    letter-spacing:1px;
}


/* ===============================
   GLASS CARD
================================ */
.glass{

    background:rgba(255,255,255,0.07);

    backdrop-filter:blur(18px);

    border-radius:18px;

    padding:22px;

    border:1px solid rgba(255,255,255,0.15);

    box-shadow:
        0 15px 40px rgba(0,0,0,0.6),
        inset 0 0 20px rgba(255,255,255,0.03);

    transition:all 0.3s ease;
}

.glass:hover{

    transform:translateY(-5px);

    box-shadow:
        0 25px 60px rgba(0,0,0,0.8),
        0 0 18px rgba(0,255,200,0.25);
}


/* ===============================
   SECURITY STAT CARDS
================================ */
.glass h6{
    opacity:0.8;
    font-size:14px;
}

.glass h2{
    font-weight:700;
    margin-top:5px;
}


/* ===============================
   TABLE STYLE
================================ */
/* ===============================
   PROFESSIONAL SECURITY TABLE
================================ */

.table{
    border-collapse:separate;
    border-spacing:0 8px;
    color:white;
}


/* TABLE HEADER */

.table thead th{

    background:rgba(0,0,0,0.55);

    border:none;

    padding:14px;

    font-size:14px;

    letter-spacing:0.5px;

    text-transform:uppercase;

    border-bottom:2px solid rgba(0,255,200,0.3);
}


/* TABLE ROW */

.table tbody tr{

    background:rgba(255,255,255,0.05);

    backdrop-filter:blur(10px);

    transition:all 0.25s ease;

    border-radius:10px;
}


/* TABLE CELL */

.table tbody td{

    padding:14px;

    border:none;

    vertical-align:middle;
}


/* HOVER EFFECT */

.table tbody tr:hover{

    background:rgba(0,255,200,0.08);

    transform:scale(1.01);

    box-shadow:0 0 15px rgba(0,255,200,0.2);
}


/* ACTION COLUMN HIGHLIGHT */

.table tbody td:nth-child(3){

    font-weight:500;

    color:#00e0ff;
}


/* IP ADDRESS STYLE */

.table tbody td:nth-child(4){

    font-family:monospace;

    color:#ffc107;
}


/* DATE STYLE */

.table tbody td:nth-child(5){

    font-size:13px;

    opacity:0.8;
}

/* ===============================
   BUTTON STYLE
================================ */
.btn-light{

    background:linear-gradient(135deg,#ffffff,#dfe9f3);

    border:none;

    font-weight:500;

    transition:0.3s;
}

.btn-light:hover{

    transform:scale(1.05);

    box-shadow:0 8px 20px rgba(0,0,0,0.4);
}


/* ===============================
   PAGINATION STYLE
================================ */
.pagination{

    justify-content:center;
}

.page-link{

    background:rgba(255,255,255,0.08);

    color:white;

    border:1px solid rgba(255,255,255,0.15);
}

.page-link:hover{

    background:rgba(0,255,200,0.2);

    color:white;
}


/* ===============================
   MOBILE
================================ */
@media(max-width:768px){

    h2{
        font-size:22px;
    }

}

/* ===============================
   THREAT MONITOR PANEL
================================ */

.threat-card{

    padding:25px;

    transition:0.3s;
}

.threat-card:hover{

    transform:translateY(-6px);

    box-shadow:0 20px 40px rgba(0,0,0,0.6);
}


/* STATUS DOT */

.status-dot{

    display:inline-block;

    width:12px;
    height:12px;

    border-radius:50%;

    margin-right:8px;

    animation:pulse 1.4s infinite;
}


/* SAFE STATUS */

.safe{

    background:#00ff9c;

    box-shadow:0 0 10px #00ff9c;
}


/* WARNING STATUS */

.warning{

    background:#ffc107;

    box-shadow:0 0 10px #ffc107;
}


/* DANGER STATUS */

.danger{

    background:#ff3b3b;

    box-shadow:0 0 12px #ff3b3b;
}


/* ANIMATION */

@keyframes pulse{

    0%{ transform:scale(1); opacity:1; }

    50%{ transform:scale(1.2); opacity:0.7; }

    100%{ transform:scale(1); opacity:1; }

}

</style>
</head>

<body>

<div class="container mt-4">

    <h2 class="mb-4">🛡 System Security Logs</h2>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-light mb-3">
        ← Back Dashboard
    </a>
    <div class="row mb-4">

    <!-- SECURITY STATUS -->
    <div class="col-md-4">
        <div class="glass threat-card text-center">

            <h6>System Status</h6>

            <h3 class="text-success">
                <span class="status-dot safe"></span>
                Secure
            </h3>

            <small>No threats detected</small>

        </div>
    </div>

    <!-- FAILED LOGIN ALERT -->
    <div class="col-md-4">
        <div class="glass threat-card text-center">

            <h6>Failed Login Attempts</h6>

            <h3 class="text-danger">
                <span class="status-dot danger"></span>
                {{ $failedLogins }}
            </h3>

            <small>Suspicious activity</small>

        </div>
    </div>

    <!-- AI INTRUDER DETECTION -->
    <div class="col-md-4">
        <div class="glass threat-card text-center">

            <h6>AI Intruder Detection</h6>

            <h3 class="text-warning">
                <span class="status-dot warning"></span>
                {{ $intruderAttempts }}
            </h3>

            <small>Keystroke anomaly detected</small>

        </div>
    </div>

</div>

    <!-- SECURITY ALERTS -->
    <div class="row mb-4">

        <div class="col-md-6">
            
        </div>

        <div class="col-md-6">
            
        </div>

    </div>

    <!-- LOG TABLE -->
    <div class="glass">

        <h5 class="mb-3">Activity History</h5>

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>IP Address</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No logs available</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $logs->links() }}
        </div>

    </div>

</div>

</body>
</html>