<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;

class VoterResultController extends Controller
{

    // =====================================
    // SHOW RESULTS PAGE
    // =====================================
    public function show($id)
    {
        // Get election using ID from URL
        $election = Election::with('candidates.votes')->findOrFail($id);

        // Block access if election is still active
        if ($election->active) {
            return redirect()
                ->route('voter.dashboard')
                ->with('error', 'Results will be available after election ends.');
        }

        $totalVotes = 0;

        // Count votes for each candidate
        foreach ($election->candidates as $candidate) {

            $candidate->votes_count = $candidate->votes->count();

            $totalVotes += $candidate->votes_count;
        }

        // Calculate vote percentage
        foreach ($election->candidates as $candidate) {

            if ($totalVotes > 0) {

                $candidate->percentage =
                    round(($candidate->votes_count / $totalVotes) * 100);

            } else {

                $candidate->percentage = 0;
            }
        }

        // Determine winner
        $winner = $election->candidates
                    ->sortByDesc('votes_count')
                    ->first();

        $candidates = $election->candidates;

        return view('voter.results', compact(
            'election',
            'candidates',
            'winner'
        ));
    }


    // =====================================
    // OPTIONAL RESULTS LIST PAGE
    // =====================================
    public function index()
    {
        // Show all ended elections
        $elections = Election::where('active',0)
                        ->orderBy('end_date','desc')
                        ->get();

        return view('voter.results_list', compact('elections'));
    }

}