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

            // If no record, unpaid, or incomplete profile -> push them to dashboard
            if (!$contestant || $contestant->payment_status == 0 || $contestant->profile_status == 0) {
                // Allow access to the dashboard itself and the processing routes
                if (!$request->routeIs('contestant.dashboard') && 
                    !$request->is('onboarding/*')) {
                    return redirect()->route('contestant.dashboard');
                }
            }
        }

        return $next($request);

    }
}
