<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberOnboardingController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Show the monthly subscription payment page.
     */
    public function index()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        // If already paid, redirect to member dashboard
        if ($member && $member->payment_status == 1) {
            return redirect()->route('member.dashboard');
        }

        return view('member.onboarding.index'); 
    }

    /**
     * Process the Stripe monthly subscription.
     */
    public function processPayment()
    {
        $user = Auth::user();
        
        $session = $this->paymentGateway->createSubscriptionSession(
            5.00, // $5 Monthly Membership
            'usd',
            route('member.onboarding.success'),
            route('member.onboarding.index'),
            ['user_id' => $user->id]
        );

        return redirect($session->url);
    }

    /**
     * Handle payment success.
     */
    public function paymentSuccess()
    {
        $user = Auth::user();
        
        // Update or create the member record
        Member::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 1,
                'subscription_ends_at' => now()->addMonth(),
                'status' => 1, // Active member
            ]
        );

        return redirect()->route('member.dashboard')->with('success', 'Welcome! Your monthly membership is now active.');
    }
}
