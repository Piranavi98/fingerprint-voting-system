<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    
    public function votePage()
    {
        $user = auth()->user();
        if (!$user->fingerprint_verified) {
            return redirect('/voter/fingerprint')
                ->with('error', 'Fingerprint verification required before voting.');
        }

        // Get candidates for active elections only
        $candidates = Candidate::with('election')
            ->whereHas('election', function ($q) {
                $q->where('active', true);
            })
            ->get();

        // Elections already voted by this voter
        $voterVotes = Vote::where('voter_id', $user->id)
            ->pluck('election_id')
            ->toArray();

        return view('voter.vote', compact('candidates', 'voterVotes'));
    }


    /**
     * Handle vote submission
     */
    public function castVote(Request $request)
    {
        $user = auth()->user();

        // 🔐 Fingerprint verification required
        if (!$user->fingerprint_verified) {
            return redirect('/voter/fingerprint')
                ->with('error', 'Fingerprint verification required before voting.');
        }

        // Validate request
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Get candidate
        $candidate = Candidate::findOrFail($request->candidate_id);

        // Prevent voting if election not active
        if (!$candidate->election || !$candidate->election->active) {
            return back()->withErrors(['This election is not active.']);
        }

        // Prevent duplicate vote
        $existingVote = Vote::where('voter_id', $user->id)
            ->where('election_id', $candidate->election_id)
            ->exists();

        if ($existingVote) {
            return back()->withErrors(['You have already voted in this election!']);
        }

        // =========================
        // SAVE VOTE
        // =========================
        Vote::create([
            'voter_id'     => $user->id,
            'candidate_id' => $candidate->id,
            'election_id'  => $candidate->election_id,
        ]);

        // =========================
        // RESET fingerprint AFTER vote
        // =========================
        $user->update([
            'fingerprint_verified' => false,
            'verified_at' => null
        ]);

        // =========================
        // ACTIVITY LOG
        // =========================
        DB::table('activity_logs')->insert([
            'user_id'    => $user->id,
            'action'     => 'Vote submitted',
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('voter.dashboard')
            ->with('success', 'Vote submitted successfully!');
    }
}
