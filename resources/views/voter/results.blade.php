<!DOCTYPE html>
<html>
<head>
    <title>Election Results</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* ===============================
BACKGROUND
=============================== */
body{
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
}

/* ===============================
TITLE
=============================== */
.main-title{
    font-size:42px;
    font-weight:800;
    letter-spacing:2px;
}

/* ===============================
GLASS CARD
=============================== */
.glass{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:30px;
}

/* ===============================
CANDIDATE CARD
=============================== */
.candidate-card{
    text-align:center;
    margin-bottom:25px;
}

.candidate-img{
    width:110px;
    height:110px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid rgba(255,255,255,0.2);
}

.candidate-name{
    margin-top:10px;
    padding:6px 18px;
    border-radius:30px;
    display:inline-block;
    background:rgba(255,255,255,0.12);
}

/* ===============================
WINNER BADGE
=============================== */
.winner-badge{
    background:gold;
    color:black;
    font-weight:700;
    padding:6px 14px;
    border-radius:30px;
}

/* ===============================
CHART SIZE
=============================== */
.chart-box{
    max-width:420px;
    margin:auto;
}

/* ===============================
MOBILE
=============================== */
@media(max-width:768px){
    .main-title{ font-size:28px; }
}

</style>
</head>

<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="text-warning fw-bold">Student Body</div>
            <div class="main-title">ELECTION RESULTS {{ date('Y') }}</div>
        </div>

        <a href="{{ route('voter.dashboard') }}" class="btn btn-outline-light">
            ← Back
        </a>
    </div>


    <div class="row">

        <!-- LEFT SIDE CHART -->
        <div class="col-lg-6">
            <div class="glass text-center">

                <h4 class="mb-3">{{ $election->title }}</h4>

                <!-- Winner -->
                @if($winner)
                    <div class="winner-badge mb-3">
                        🏆 Winner: {{ $winner->name }}
                    </div>
                @endif

                <div class="chart-box">
                    <canvas id="resultChart"></canvas>
                </div>

            </div>
        </div>


        <!-- RIGHT SIDE CANDIDATES -->
        <div class="col-lg-6">
            <div class="glass">

                <div class="row">

                    @foreach($candidates as $candidate)
                    <div class="col-6 candidate-card">

                        <img src="{{ asset('uploads/candidates/'.$candidate->image) }}"
                             class="candidate-img">

                        <div class="candidate-name">
                            {{ $candidate->name }}
                        </div>

                        <div>
                            {{ $candidate->votes_count }} votes
                            ({{ $candidate->percentage }}%)
                        </div>

                    </div>
                    @endforeach

                </div>

            </div>
        </div>

    </div>

</div>


<!-- ===============================
CHART JS
=============================== -->
<script>

new Chart(document.getElementById('resultChart'),{
    type:'pie',
    data:{
        labels:[
            @foreach($candidates as $c)
            '{{ $c->name }}',
            @endforeach
        ],
        datasets:[{
            data:[
                @foreach($candidates as $c)
                {{ $c->votes_count }},
                @endforeach
            ]
        }]
    },
    options:{
        plugins:{
            legend:{ position:'bottom' }
        }
    }
});

</script>

</body>
</html>