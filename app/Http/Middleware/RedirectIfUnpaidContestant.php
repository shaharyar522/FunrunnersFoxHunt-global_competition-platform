<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Contestant;

class RedirectIfUnpaidContestant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'contestant') {
            $contestant = Contestant::where('user_id', $user->id)->first();

            // 1. If no contestant record exists or they haven't paid, send them to payment
            if (!$contestant || $contestant->payment_status == 0) {
                // Allow access to the onboarding/payment routes to avoid infinite loop
                if (!$request->is('onboarding') && !$request->is('onboarding/pay') && !$request->is('onboarding/success')) {
                    return redirect()->route('contestant.onboarding.index');
                }
            } 
            // 2. If paid but profile incomplete, send them to profile setup
            elseif ($contestant->profile_status == 0) {
                // Allow access to profile setup routes to avoid infinite loop
                if (!$request->is('onboarding/profile-setup')) {
                    return redirect()->route('contestant.profile.setup');
                }
            }
        }

        return $next($request);
    }
}
