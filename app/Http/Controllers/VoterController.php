<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Election;

class VoterController extends Controller
{
    // Dashboard method
    public function dashboard()
    {
        $user = Auth::user();
        $electionActive = Election::where('active', true)->exists();
        return view('voter.dashboard', compact('user','electionActive'));
    }

    // Fingerprint verification (optional)
    public function verifyFingerprint(Request $request)
    {
        return response()->json(['message' => 'Fingerprint verified']);
    }

     public function manageVoters()
    {
        $voters = User::where('role', 'voter')->get();
        return view('admin.voters.manageVoters', compact('voters'));
    }

}
