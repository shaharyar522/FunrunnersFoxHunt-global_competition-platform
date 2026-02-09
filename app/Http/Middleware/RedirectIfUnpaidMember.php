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

            // And main both condition true hnti hain
            // OR main only one condition agr true hn tu work karta hian

            // agr member nhi hian
            // member ki payment_status => unpaid hian
            // member ki subscription date end montly base end hnay wali hin
            // in sare main koe conditin bhi agr pass karti hian tu agry code run hnga


            // If no member record exists or they haven't paid or subscription expired

            if (!$member || $member->payment_status == 0 || (isset($member->subscription_ends_at) && now()->gt($member->subscription_ends_at))) {

                // Allow access to the dashboard itself and the processing routes
                if (
                    !$request->routeIs('member.dashboard') &&
                    !$request->is('member/pay*') &&
                    !$request->is('member/success*')
                ) {

                    $message = ($member && $member->subscription_ends_at && now()->gt($member->subscription_ends_at))
                        ? 'Your monthly subscription has expired. Please renew to continue.'
                        : 'Please complete your monthly membership payment to access the dashboard.';

                    return redirect()->route('member.dashboard')->with('warning', $message);
                }
            }
        }

        return $next($request);

    }
}
