<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Candidate;

class VoterController extends Controller
{

    // =============================
    // VOTER DASHBOARD
    // =============================
   public function dashboard()
{
    $user = Auth::user();

    $electionActive = Election::where('active',1)->exists();

    $endedElection = null;

    $vote = Vote::latest()->first();

    if($vote){

        $candidate = Candidate::find($vote->candidate_id);

        if($candidate){

            $endedElection = Election::where('id',$candidate->election_id)
                            ->where('active',0)
                            ->first();
        }
    }

    return view('voter.dashboard', compact(
        'user',
        'electionActive',
        'endedElection'
    ));
}
    // =============================
    // FINGERPRINT VERIFY (ANDROID)
    // =============================
    public function verifyFingerprint(Request $request)
    {
        return response()->json([
            'message' => 'Fingerprint verified'
        ]);
    }


    // =============================
    // ADMIN - MANAGE VOTERS
    // =============================
    public function manageVoters()
    {
        $voters = User::where('role','voter')->get();

        return view('admin.voters.manageVoters', compact('voters'));
    }

}