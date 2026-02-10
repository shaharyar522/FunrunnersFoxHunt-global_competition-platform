<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    // -------------------
    // GOOGLE LOGIN
    // -------------------

    public function redirectToGoogle(Request $request)

    {


        if ($request->has('role')) {

            session(['intended_role' => $request->role]);

        }

        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {


        $socialUser = Socialite::driver('google')->user();

        $role = session('intended_role', 'member'); // Default to member if not set

        $user = $this->findOrCreateUser($socialUser, 'google', $role);

        Auth::login($user);

        session()->forget('intended_role');

        return $this->redirectToDashboard($user);

    }

    // -------------------
    // TWITTER/X LOGIN
    // -------------------
    public function redirectToTwitter(Request $request)
    {

        if ($request->has('role')) {
            session(['intended_role' => $request->role]);
        }
        return Socialite::driver('twitter')->redirect();

    }

    public function handleTwitterCallback()
    {

        $socialUser = Socialite::driver('twitter')->user();
        $role = session('intended_role', 'member');
        $user = $this->findOrCreateUser($socialUser, 'twitter', $role);
        
        Auth::login($user);

        session()->forget('intended_role');
        return $this->redirectToDashboard($user);
    }

    // -------------------
    // FACEBOOK LOGIN MOCK
    // -------------------
    public function redirectToFacebookMock(Request $request)
    {

        $role = $request->get('role', 'member');

        $user = User::firstOrCreate(
            ['email' => 'fbuser@test.com'],

            [
                'name' => 'Facebook Test User',
                'provider' => 'facebook',
                'provider_id' => '12345',
                'password' => bcrypt(uniqid()),
                'role' => $role
            ]
        );

        Auth::login($user);
        return $this->redirectToDashboard($user);
    }

    // -------------------
    // HELPER: Find or create user
    // -------------------
    private function findOrCreateUser($socialUser, $provider, $role)
    {
        $user = User::where('provider_id', $socialUser->id)
            ->where('provider', $provider)
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email ?? $socialUser->id . '@' . $provider . '.com',
                'provider' => $provider,
                'provider_id' => $socialUser->id,
                'role' => $role,
                'password' => bcrypt(uniqid()), // dummy password
            ]);
        } else {
            // FOR TESTING: Update role if user exists but wants to switch roles
            // In a strict production environment, you might prevent this, but for testing it's essential.

            if ($user->role !== $role) {
                $user->role = $role;
                $user->save();
            }
        }

        return $user;
    }

    // -------------------
    // HELPER: Redirect based on role
    // -------------------
    private function redirectToDashboard($user)
    {
        if ($user->role == 'contestant') {

            // Don't create contestant record here - let dashboard handle the flow
            // Flow: Login -> Dashboard checks payment -> Payment -> Profile -> Dashboard
            return redirect()->route('contestant.dashboard');
        }

        if ($user->role == 'member') {
            // Flow: Login -> Dashboard checks subscription -> Payment if needed
            return redirect()->route('member.dashboard');
        }


        return redirect()->route('admin.dashboard');
    }
}
