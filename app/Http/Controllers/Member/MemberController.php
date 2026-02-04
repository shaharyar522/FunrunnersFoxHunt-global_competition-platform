<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Main Dashboard: Handles showing the correct view (Payment or Dashboard)
     * based on the member's current status.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        // 1. Ensure member record exists
        if (!$member) {
            $member = Member::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 0,
                'status' => 1,
            ]);
        }

        // 2. Check for payment or expired subscription
        if ($member->payment_status == 0 || ($member->subscription_ends_at && now()->gt($member->subscription_ends_at))) {
            return view('member.onboarding.index', compact('member'));
        }

        // 3. Active member dashboard
        $activeRounds = \App\Models\Voting::where('status', 1)->get();

        return view('member.dashboard', compact('member', 'activeRounds'));
    }

    /**
     * Process Payment Action
     */
    public function paymentProcess()
    {
        $user = Auth::user();
        
        $session = $this->paymentGateway->createSubscriptionSession(
            5.00, // $5 Monthly Membership
            'usd',
            route('member.paymentSuccess'),
            route('member.dashboard'), // Back to dashboard if canceled
            ['user_id' => $user->id]
        );

        return redirect($session->url);
    }

    /**
     * Handle Success Payment Action
     */
    public function paymentSuccess()
    {
        $user = Auth::user();
        
        Member::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 1,
                'subscription_ends_at' => now()->addMonth(),
                'status' => 1,
            ]
        );

        return redirect()->route('member.dashboard')
            ->with('success', 'Welcome! Your monthly membership is now active.');
    }

    public function showVotingRound($voting_id)
    {
        $voting = \App\Models\Voting::with(['votingContestants.contestant.questions' => function($q) {
            $q->where('is_answered', true)->with('member')->orderBy('created_at', 'desc');
        }])->findOrFail($voting_id);

        // Check if user has already voted
        $userVote = \App\Models\Vote::where('user_id', Auth::id())
                                    ->where('voting_id', $voting_id)
                                    ->first();

        $votedContestantId = $userVote ? $userVote->contestant_id : null;

        return view('member.contestants.index', compact('voting', 'votedContestantId'));
    }

    public function liveResults($voting_id)
    {
        $voting = \App\Models\Voting::findOrFail($voting_id);

        $results = \App\Models\Vote::where('voting_id', $voting_id)
            ->select('contestant_id', \Illuminate\Support\Facades\DB::raw('count(*) as total_votes'))
            ->groupBy('contestant_id')
            ->orderByDesc('total_votes')
            ->with(['contestant'])
            ->get();

        return view('member.results.index', compact('voting', 'results'));
    }
}
