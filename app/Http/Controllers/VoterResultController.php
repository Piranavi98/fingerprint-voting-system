<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Election;

class VoterResultController extends Controller
{
   public function index()
{
    // get latest election
    $election = Election::with('candidates.votes')->latest()->first();

    if(!$election){
        return back()->with('error','No election found');
    }

    // 🚫 BLOCK if election still running
    if($election->active){
        return redirect()->route('voter.dashboard')
            ->with('error','Results will be available after election ends.');
    }

    // calculate votes
    $totalVotes = 0;

    foreach($election->candidates as $c){
        $c->votes_count = $c->votes->count();
        $totalVotes += $c->votes_count;
    }

    foreach($election->candidates as $c){
        $c->percentage = $totalVotes > 0
            ? round(($c->votes_count / $totalVotes) * 100, 2)
            : 0;
    }

    $winner = $election->candidates
                ->sortByDesc('votes_count')
                ->first();

    return view('voter.results', compact(
        'election','winner'
    ))->with('candidates',$election->candidates);
}
}
