<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FingerprintController extends Controller
{
    /**
     * Android API verification endpoint
     */
    public function verify(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'voter_id' => 'required|exists:users,id',
            'status'   => 'required'
        ]);

        // If fingerprint success
        if ($request->status === 'success') {

            $voter = User::findOrFail($request->voter_id);

            // ✅ Update fingerprint verification + timestamp
            $voter->update([
                'fingerprint_verified' => true,
                'verified_at' => now()
            ]);

            // ✅ Fingerprint audit log (biometric event log)
            DB::table('fingerprint_logs')->insert([
                'user_id'     => $voter->id,
                'verified_at' => now(),
                'device_used' => $request->header('User-Agent'),
                'ip_address'  => $request->ip(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // ✅ General activity log (security compliance)
            DB::table('activity_logs')->insert([
                'user_id'    => $voter->id,
                'action'     => 'Fingerprint verified',
                'ip_address' => $request->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Fingerprint verified successfully'
            ]);
        }

        // ❌ Failed verification log
        DB::table('activity_logs')->insert([
            'user_id'    => $request->voter_id,
            'action'     => 'Fingerprint verification failed',
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Fingerprint verification failed'
        ], 401);
    }


    /**
     * Show fingerprint page
     */
    public function show()
    {
        return view('voter.fingerprint');
    }


    /**
     * Demo verification (for testing only)
     */
    public function demoVerify()
    {
        auth()->user()->update([
            'fingerprint_verified' => true,
            'verified_at' => now()
        ]);

        // Demo activity log
        DB::table('activity_logs')->insert([
            'user_id'    => auth()->id(),
            'action'     => 'Fingerprint verified (demo)',
            'ip_address' => request()->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/voter/fingerprint')
            ->with('success', 'Fingerprint verified successfully.');
    }
}
