<!DOCTYPE html>
<html>
<head>
    <title>System Logs</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* BACKGROUND */
body{
    min-height:100vh;
    background:linear-gradient(rgba(10,20,40,0.8),rgba(10,20,40,0.8)),
    url('https://images.unsplash.com/photo-1555949963-aa79dcee981c');
    background-size:cover;
    color:white;
}

/* GLASS CARD */
.glass{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(12px);
    border-radius:16px;
    padding:20px;
    border:1px solid rgba(255,255,255,0.15);
}

/* TABLE */
.table{
    color:white;
}

.table thead{
    background:rgba(255,255,255,0.15);
}

</style>
</head>

<body>

<div class="container mt-4">

    <h2 class="mb-4">🛡 System Security Logs</h2>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-light mb-3">
        ← Back Dashboard
    </a>

    <!-- SECURITY ALERTS -->
    <div class="row mb-4">

        <div class="col-md-6">
            <div class="glass text-center">
                <h6>Failed Logins</h6>
                <h2 class="text-danger">{{ $failedLogins }}</h2>
            </div>
        </div>

        <div class="col-md-6">
            <div class="glass text-center">
                <h6>Intruder Attempts (AI)</h6>
                <h2 class="text-warning">{{ $intruderAttempts }}</h2>
            </div>
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