<!DOCTYPE html>
<html>
<head>
    <title>Cast Your Vote</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        /* ===============================
           GLOBAL GLASS BACKGROUND
        =============================== */
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;

            background:
            linear-gradient(rgba(10,20,40,0.75), rgba(10,20,40,0.75)),
            url('https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1500&q=80');

            background-size: cover;
            background-position: center;
            color: white;
        }

        /* ===============================
           GLASS NAVBAR
        =============================== */
        .glass-navbar {
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(12px);
        }

        /* ===============================
           GLASS CARD
        =============================== */
        .glass-card {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(16px);
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            transition: 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
        }

        /* ===============================
           CANDIDATE CARD
        =============================== */
        .candidate-card {
            cursor: pointer;
            padding: 20px;
            text-align: center;
        }

        .candidate-selected {
            border: 2px solid #0d6efd;
            box-shadow: 0 0 20px rgba(13,110,253,0.4);
        }

        /* ===============================
           IMAGE
        =============================== */
        .candidate-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.4);
            margin-bottom: 10px;
        }

        /* ===============================
           BUTTONS
        =============================== */
        .glass-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            border-radius: 10px;
        }

        .glass-btn:hover {
            background: rgba(255,255,255,0.25);
        }

        .vote-btn {
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 12px;
        }

        /* ===============================
           MOBILE
        =============================== */
        @media(max-width:768px){
            .candidate-img {
                width:65px;
                height:65px;
            }
        }

    </style>
</head>

<body>

<!-- ===============================
     NAVBAR
=============================== -->
<nav class="navbar glass-navbar navbar-dark shadow-sm">
    <div class="container-fluid px-4">

        <span class="navbar-brand fw-bold">
            <i class="bi bi-shield-lock"></i> Secure E-Voting
        </span>

        <div class="d-flex align-items-center">
            <span class="me-3">{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>

    </div>
</nav>


<!-- ===============================
     CONTENT
=============================== -->
<div class="container py-5">

    <!-- Title + Back -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">🗳 Cast Your Vote</h2>

        <a href="{{ route('voter.dashboard') }}" class="btn glass-btn">
            ← Back to Dashboard
        </a>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <!-- ===============================
         FORM
    =============================== -->
    <form action="{{ url('/voter/vote') }}" method="POST" id="voteForm">
        @csrf

        <div class="row g-4">

            @foreach($candidates as $candidate)
            <div class="col-lg-4 col-md-6">

                <div class="glass-card candidate-card"
                     onclick="selectCandidate(this)">

                    @if($candidate->image)
                        <img src="{{ asset('uploads/candidates/'.$candidate->image) }}"
                             class="candidate-img">
                    @else
                        <img src="https://via.placeholder.com/80"
                             class="candidate-img">
                    @endif

                    <h5 class="fw-bold mb-1">{{ $candidate->name }}</h5>
                    <small class="text-light">{{ $candidate->party }}</small>

                    <input type="radio"
                           name="candidate_id"
                           value="{{ $candidate->id }}"
                           class="d-none"
                           required>

                    <div class="mt-2 small text-light">
                        Click to select
                    </div>

                </div>

            </div>
            @endforeach

        </div>

        <div class="text-center mt-5">
            <button class="btn btn-primary vote-btn">
                Submit Vote
            </button>
        </div>

    </form>

</div>


<!-- ===============================
     SCRIPT
=============================== -->
<script>

function selectCandidate(card)
{
    document.querySelectorAll('.candidate-card')
        .forEach(c => c.classList.remove('candidate-selected'));

    card.classList.add('candidate-selected');
    card.querySelector('input[type=radio]').checked = true;
}

document.getElementById('voteForm').addEventListener('submit', function(e) {

    if(!confirm("Are you sure you want to submit your vote? This cannot be changed.")) {
        e.preventDefault();
    }

});
</script>

</body>
</html>
