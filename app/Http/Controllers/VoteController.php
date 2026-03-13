<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{

    // ==============================
    // SHOW VOTING PAGE
    // ==============================
    public function votePage()
    {
        $user = auth()->user();

        // Fingerprint verification required
        if (!$user->fingerprint_verified) {
            return redirect('/voter/fingerprint')
                ->with('error', 'Fingerprint verification required before voting.');
        }

        // Get candidates only for ACTIVE elections
        $candidates = Candidate::with('election')
            ->whereHas('election', function ($q) {
                $q->where('active', 1);
            })
            ->get();

        // Elections already voted by voter
        $voterVotes = Vote::where('voter_id', $user->id)
            ->pluck('election_id')
            ->toArray();
            

        return view('voter.vote', compact('candidates', 'voterVotes'));
    }


    // ==============================
    // CAST VOTE
    // ==============================
    public function castVote(Request $request)
    {

        $user = auth()->user();

        // Fingerprint verification required
        if (!$user->fingerprint_verified) {
            return redirect('/voter/fingerprint')
                ->with('error', 'Fingerprint verification required before voting.');
        }

        // Validate request
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Get candidate
        $candidate = Candidate::with('election')->findOrFail($request->candidate_id);

        // Check if election active
        if (!$candidate->election || $candidate->election->active != 1) {
            return redirect()->route('voter.dashboard')
                ->with('error', 'This election is not active.');
        }

        // Prevent duplicate vote
        $existingVote = Vote::where('voter_id', $user->id)
            ->where('election_id', $candidate->election_id)
            ->exists();

        if ($existingVote) {
            return redirect()->route('voter.dashboard')
                ->with('error', 'You have already voted in this election.');
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
        // RESET fingerprint after vote
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

        // =========================
        // REDIRECT WITH RECEIPT DATA
        // =========================
        return redirect()->route('voter.receipt')
            ->with([
                'candidate' => $candidate->name,
                'election'  => $candidate->election->title,
                'time'      => now()->format('h:i A')
            ]);
    }
    

}