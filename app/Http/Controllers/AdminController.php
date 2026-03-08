<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * ===============================
     * ADMIN DASHBOARD
     * ===============================
     */
    public function dashboard()
    {
        // --------------------------------
        // BASIC SYSTEM COUNTS
        // --------------------------------
        $voters     = User::where('role', 'voter')->count();
        $admins     = User::where('role', 'admin')->count();
        $candidates = Candidate::count();
        $elections  = Election::count();
        $votes      = Vote::count();

        // --------------------------------
        // ACTIVE ELECTION STATUS
        // --------------------------------
        $electionActive = Election::where('active', true)->exists();

        // --------------------------------
        // BIOMETRIC ANALYTICS
        // --------------------------------

        // ✅ Total successful verifications
        $totalVerifications = DB::table('fingerprint_logs')->count();

        // ✅ Failed fingerprint attempts (from activity logs)
        $failedAttempts = DB::table('activity_logs')
            ->where('action', 'Fingerprint verification failed')
            ->count();

        // ✅ Device usage statistics
        $deviceUsage = DB::table('fingerprint_logs')
            ->select('device_used', DB::raw('COUNT(*) as total'))
            ->groupBy('device_used')
            ->get();

        // --------------------------------
        // RECENT SYSTEM ACTIVITIES
        // --------------------------------
        $recentActivities = DB::table('activity_logs')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'voters',
            'admins',
            'candidates',
            'elections',
            'votes',
            'electionActive',
            'totalVerifications',
            'failedAttempts',
            'deviceUsage',
            'recentActivities'
        ));
    }


    /**
     * ===============================
     * SHOW CREATE ADMIN FORM
     * ===============================
     */
    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    public function exportResultsPdf($id)
{
    $election = Election::with(['candidates.votes','voters'])
        ->findOrFail($id);

    $totalVotes = $election->candidates->sum(fn($c) => $c->votes->count());

    // sort candidates by vote count
    $sortedCandidates = $election->candidates
        ->sortByDesc(fn($c) => $c->votes->count())
        ->values();

    // detect winner or tie
    $topVote = $sortedCandidates->first()->votes->count() ?? 0;
    $winners = $sortedCandidates->filter(
        fn($c) => $c->votes->count() == $topVote
    );
    $isTie = $winners->count() > 1;
    $pdf = Pdf::loadView('admin.results_pdf', compact(
        'election',
        'totalVotes',
        'winners',
        'isTie'
    ));

    return $pdf->download('election_results.pdf');
}

    /**
     * ===============================
     * STORE NEW ADMIN
     * ===============================
     */


    public function storeAdmin(Request $request)
    {
        // --------------------------------
        // VALIDATION
        // --------------------------------
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // --------------------------------
        // CREATE ADMIN USER
        // --------------------------------
        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        // --------------------------------
        // LOG ACTIVITY (SECURITY COMPLIANCE)
        // --------------------------------
        DB::table('activity_logs')->insert([
            'user_id'    => auth()->id(),
            'action'     => 'Admin created: ' . $admin->email,
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Admin account created successfully');
    }
}
