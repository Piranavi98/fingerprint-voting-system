<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use GuzzleHttp\Client;
use App\Mail\VoterCredentialsMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /*
        ======================================
        KEYSTROKE AI AUTHENTICATION
        ======================================
        */
        if ($request->filled('typing_pattern')) {

            try {

                $typingPattern = json_decode($request->typing_pattern, true);

                $client = new Client(['timeout' => 3]);

                $response = $client->post('http://127.0.0.1:5000/predict', [
                    'json' => [
                        'typing_pattern' => $typingPattern
                    ]
                ]);

                $result = json_decode($response->getBody(), true);

                if ($result['result'] === 'intruder') {

                    DB::table('activity_logs')->insert([
                        'user_id' => null,
                        'action' => 'Keystroke authentication failed',
                        'ip_address' => $request->ip(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    return back()->withErrors([
                        'email' => 'Abnormal typing behaviour detected. Access denied.'
                    ]);
                }

            } catch (\Exception $e) {
                // AI server error ignore
            }
        }

        /*
        ======================================
        PASSWORD LOGIN
        ======================================
        */
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials'
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        /*
        ======================================
        GENERATE API TOKEN
        ======================================
        */
        $user->api_token = Str::random(60);
        $user->save();

        /*
        ======================================
        SAVE KEYSTROKE DATA
        ======================================
        */
        if ($request->filled('typing_pattern')) {

            DB::table('keystroke_logs')->insert([
                'user_id' => $user->id,
                'typing_pattern' => $request->typing_pattern,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        /*
        ======================================
        LOGIN ACTIVITY LOG
        ======================================
        */
        DB::table('activity_logs')->insert([
            'user_id' => $user->id,
            'action' => 'User logged in',
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        /*
        ======================================
        REDIRECT
        ======================================
        */
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        if ($user->role === 'voter') {
            return redirect('/voter/dashboard');
        }

        Auth::logout();

        return back()->withErrors([
            'email' => 'User role not recognized'
        ]);
    }

    public function logout(Request $request)
    {
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'User logged out',
            'ip_address' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegister()
{
    return view('auth.register');
}
public function register(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'role'     => 'sometimes|in:admin,voter'
    ]);

    $role = $data['role'] ?? 'voter';

    if ($role === 'admin' && (!Auth::check() || Auth::user()->role !== 'admin')) {
        $role = 'voter';
    }

    $plainPassword = $data['password'];

    User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($plainPassword),
        'role'     => $role
    ]);

    
    Mail::to($data['email'])->send(
        new VoterCredentialsMail($data['name'], $data['email'], $plainPassword)
    );

    return redirect()->route('login')
        ->with('success', 'Registration successful. Login details sent to voter email.');
}

}