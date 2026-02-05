<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle manual login via email and password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([

            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        if (Auth::attempt($credentials, $request->remember)) {

            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'contestant') {

                return redirect()->route('contestant.dashboard');

            } elseif ($user->role === 'member') {

                return redirect()->route('member.dashboard');

            } elseif ($user->role === 'admin') {
                
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

    }


}
