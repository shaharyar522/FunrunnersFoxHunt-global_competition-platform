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

            // If no contestant record exists or they haven't paid, send them to payment
            if (!$contestant || $contestant->payment_status == 0) {
                // Allow access to the onboarding/payment routes to avoid infinite loop
                if (!$request->is('onboarding*')) {
                    return redirect()->route('contestant.onboarding.index');
                }
            }
        }

        return $next($request);
    }
}
