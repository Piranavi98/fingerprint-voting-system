<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

/* ===============================
   SMALL PIE CHART CONTAINER
=============================== */
.chart-box{
    width:100%;
    max-width:320px;
    margin:20px auto;
}

/* ===============================
   BUTTON
=============================== */
.btn{
    border-radius:10px;
}

</style>
</head>

<body>

<div class="container mt-5">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-bar-chart-line"></i>
        Election Results Analytics
    </h2>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
</div>


@foreach($elections as $election)

@php
$totalVotes = $election->candidates->sum(fn($c)=>$c->votes->count());
$winner = $election->candidates->sortByDesc(fn($c)=>$c->votes->count())->first();
$turnout = $election->voters->count();
$turnoutPercentage = $turnout>0 && $totalVotes>0 ? round(($totalVotes/$turnout)*100,2) : 0;

$status = $election->active ? 'Ongoing' : 'Completed';
$badgeColor = $election->active ? 'warning' : 'success';
@endphp


<!-- ===============================
   ELECTION CARD
=============================== -->
<div class="glass-card mb-4 p-4">

<!-- TITLE -->
<div class="d-flex justify-content-between align-items-center mb-3">

<h4>
{{ $election->title }}
<span class="badge bg-{{ $badgeColor }}">{{ $status }}</span>
</h4>

<div>
<a href="/admin/results/export/pdf/{{ $election->id }}"
   class="btn btn-outline-danger btn-sm">
   Export PDF
</a>

<a href="/admin/results/export/csv/{{ $election->id }}"
   class="btn btn-outline-info btn-sm">
   Export CSV
</a>
</div>

</div>


<!-- STATS -->
<div class="row text-center mb-3">

<div class="col-md-6">
<p><strong>Voter Turnout</strong></p>
<h4>{{ $turnoutPercentage }}%</h4>
</div>

<div class="col-md-6">
<p><strong>Winner</strong></p>
<h5>
@if($winner)
{{ $winner->name }} ({{ $winner->votes->count() }} votes)
@else
N/A
@endif
</h5>
</div>

</div>


<!-- ===============================
   SMALL PIE CHART
=============================== -->
@if($election->candidates->isNotEmpty())
<div class="chart-box">
<canvas id="chart-{{ $election->id }}"></canvas>
</div>
@endif


<!-- ===============================
   RESULT TABLE
=============================== -->
<div class="table-responsive mt-4">
<table class="table table-bordered text-center align-middle">

<thead>
<tr>
<th>#</th>
<th>Candidate</th>
<th>Votes</th>
<th>%</th>
</tr>
</thead>

<tbody>
@forelse($election->candidates as $candidate)

@php
$percentage = $totalVotes>0
? round(($candidate->votes->count()/$totalVotes)*100,2)
:0;
@endphp

<tr @if($winner && $candidate->id==$winner->id)
class="table-success"
@endif>

<td>{{ $loop->iteration }}</td>
<td>{{ $candidate->name }}</td>
<td>{{ $candidate->votes->count() }}</td>
<td>{{ $percentage }}%</td>

</tr>

@empty
<tr>
<td colspan="4">No candidates available</td>
</tr>
@endforelse
</tbody>

</table>
</div>

</div>


<!-- ===============================
   PIE CHART SCRIPT
=============================== -->
@if($election->candidates->isNotEmpty())
<script>
new Chart(document.getElementById('chart-{{ $election->id }}'),{
type:'pie',
data:{
labels:[
@foreach($election->candidates as $candidate)
'{{ $candidate->name }}',
@endforeach
],
datasets:[{
data:[
@foreach($election->candidates as $candidate)
{{ $candidate->votes->count() }},
@endforeach
],
backgroundColor:[
'#00c6ff','#28a745','#ffc107','#ff4d6d',
'#6f42c1','#17a2b8','#fd7e14'
]
}]
},
options:{
responsive:true,
maintainAspectRatio:false,
plugins:{
legend:{ position:'bottom' }
}
}
});
</script>
@endif


@endforeach


@if($elections->isEmpty())
<div class="text-center mt-5">
No election results available.
</div>
@endif

</div>

</body>
</html>
