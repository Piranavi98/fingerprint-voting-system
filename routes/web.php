<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FingerprintController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\VoterResultController;
use App\Http\Controllers\SystemLogsController;

// Redirect root
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('voter.dashboard');
    }
    return redirect()->route('login');
});

// ---------------------------
// AUTH ROUTES
// ---------------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------------------------
// PROTECTED ROUTES
// ---------------------------
Route::middleware(['auth'])->group(function () {

    Route::middleware(['admin'])->prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // Candidates
        Route::get('/candidates', [CandidateController::class, 'index']);
        Route::get('/candidates/create', [CandidateController::class, 'create']);
        Route::post('/candidates/store', [CandidateController::class, 'store'])->name('admin.candidates.store');
        Route::get('/candidates/edit/{id}', [CandidateController::class, 'edit']);
        Route::post('/candidates/update/{id}', [CandidateController::class, 'update'])->name('candidates.update');
        Route::get('/candidates/delete/{id}', [CandidateController::class, 'destroy']);

        // Elections
        Route::get('/elections', [ElectionController::class, 'index']);
        Route::get('/elections/create', [ElectionController::class, 'create']);
        Route::post('/elections/store', [ElectionController::class, 'store']);
        Route::get('/elections/edit/{id}', [ElectionController::class, 'edit']);
        Route::post('/elections/update/{id}', [ElectionController::class, 'update']);
        Route::get('/elections/delete/{id}', [ElectionController::class, 'destroy']);
        Route::get('/elections/toggle/{id}', [ElectionController::class, 'toggleElection'])
    ->name('admin.elections.toggle');

        // Voters
        Route::get('/voters', [VoterController::class, 'manageVoters'])
            ->name('admin.voters');

        // Results
        Route::get('/results', [ResultController::class, 'index'])
            ->name('admin.results');
        Route::get('/results/export/pdf/{id}', [ResultController::class, 'exportPdf']);
        Route::get('/results/export/csv/{id}', [ResultController::class, 'exportCsv']);
    });

    Route::middleware(['voter'])->group(function () {

        Route::get('/voter/dashboard', [VoterController::class, 'dashboard'])
            ->name('voter.dashboard');

        Route::get('/voter/vote', [VoteController::class, 'votePage']);
        Route::post('/voter/vote', [VoteController::class, 'castVote']);

        Route::post('/voter/fingerprint-verify', [VoterController::class, 'verifyFingerprint']);
        Route::get('/voter/fingerprint', [FingerprintController::class, 'show']);
        Route::get('/voter/fingerprint/demo', [FingerprintController::class, 'demoVerify'])
            ->name('fingerprint.demo');
    });

Route::get('/admin/admins/create', [AdminController::class, 'createAdmin'])
    ->name('admin.admins.create');

Route::post('/admin/admins/store', [AdminController::class, 'storeAdmin'])
    ->name('admin.admins.store');

    
Route::get('/voter/fingerprint', [FingerprintController::class, 'show'])
->name('fingerprint.show');

// Receive verification result (simulated Android response)
Route::post('/voter/fingerprint/verify', [FingerprintController::class, 'verify'])
->name('fingerprint.verify');

// Voting
Route::get('/voter/vote', [VoteController::class, 'votePage'])
->name('voter.vote');
Route::post('/voter/vote', [VoteController::class, 'castVote'])
->name('voter.vote.cast');

Route::get('/admin/results/export/pdf/{id}',
    [AdminController::class, 'exportResultsPdf']
)->name('admin.results.export.pdf');

Route::get('/fingerprint/status', function () {
    return response()->json([
        'verified' => auth()->user()->fingerprint_verified
    ]);
})->middleware('auth');

Route::get('/voter/results', [VoterResultController::class,'index'])
->name('voter.results');

Route::get('/voter/results/{id}', [VoterResultController::class,'show'])
->name('voter.results.show');

Route::get('/voter/receipt', function () {
    return view('voter.receipt');
})->name('voter.receipt');

    Route::get('/admin/logs', [SystemLogsController::class, 'index'])
    ->name('admin.logs');
    
});
