<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class RedirectIfUnpaidMember
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'member') {
            $member = Member::where('user_id', $user->id)->first();

            // If no member record exists or they haven't paid or subscription expired
            if (!$member || $member->payment_status == 0 || (isset($member->subscription_ends_at) && now()->gt($member->subscription_ends_at))) {
                // Allow access to the onboarding/payment routes to avoid infinite loop
                if (!$request->is('member/onboarding*')) {
                    $message = ($member && $member->subscription_ends_at && now()->gt($member->subscription_ends_at)) 
                               ? 'Your monthly subscription has expired. Please renew to continue.' 
                               : 'Please complete your monthly membership payment to access the dashboard.';
                    
                    return redirect()->route('member.onboarding.index')->with('warning', $message);
                }
            }
            
        }

        return $next($request);
    }
}

