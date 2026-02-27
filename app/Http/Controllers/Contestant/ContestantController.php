<?php

namespace App\Http\Controllers\Contestant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\VotingContestant;
use App\Models\Region;
use App\Models\Voting;
use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Support\Facades\Auth;

class ContestantController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {

        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Main Dashboard: Handles showing the correct view (Payment, Profile Setup, or Dashboard)
     * based on the contestant's current status.
     */

    public function dashboard()
    {
        $user = Auth::user();
        $contestant = Contestant::where('user_id', $user->id)->first();

        // 1. Ensure contestant record exists
        if (!$contestant) {

            $contestant = Contestant::create([  

                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 0,
                'profile_status' => 0,
                'status' => 1
            ]);
        }

        // 2. Check if contestant already paid (query voting_contestants table)
        $votingContestant = VotingContestant::where('contestant_id', $contestant->id)
            ->limit(1)
            ->first();

        // If entry exists in voting_contestants, contestant has already paid

        if ($votingContestant) {
            $contestant->payment_status = 1;
            $contestant->save();
        }

        // 3. State: Unpaid - Show payment page
        if ($contestant->payment_status == 0) {

            return view('contestant.payment.payment_required');
        }

        // 4. State: Paid but Profile Incomplete
        if ($contestant->profile_status == 0) {

            $regions = Region::all();

            return view('contestant.profile.contestant_profile', compact('contestant', 'regions'));
        }



        // ✅ Fetch all votings
        $rounds = Voting::orderBy('creationdate', 'desc')->get();

        // ✅ Check if contestant applied for each voting and get total applied counts
        foreach($rounds as $round) {

            $round->already_applied = VotingContestant::where('voting_id', $round->voting_id)
                ->where('contestant_id', $contestant->id)
                ->exists();
            $round->applied_count = VotingContestant::where('voting_id', $round->voting_id)->count();

            // ✅ Get first 3 contestants who applied to this round (for avatar display)
            $round->sample_contestants = Contestant::whereHas('votingContestants', function($query) use ($round) {
                $query->where('voting_id', $round->voting_id);
            })
            ->limit(3)
            ->get(['id', 'image', 'name']);
        }

        $applying_contestants = Contestant::where('status', 0)->count();
        return view('contestant.dashboard', compact('contestant', 'rounds', 'applying_contestants'));
    }

    /**
     * Apply to a Specific Voting Round
     */
    
    public function applyToRound($voting_id)
    {

        $user = Auth::user();
        $contestant = Contestant::where('user_id', $user->id)->firstOrFail();

        // 1. Check if already applied to THIS round
        $alreadyApplied = VotingContestant::where('voting_id', $voting_id)
            ->where('contestant_id', $contestant->id)
            ->first();

        if($alreadyApplied) {
            return response()->json(['success' => false, 'message' => 'You have already applied for this round.']);
        }

        // 2. Find a "floating" payment (voting_id is NULL)
        $floatingPayment = VotingContestant::where('contestant_id', $contestant->id)
            ->whereNull('voting_id')
            ->first();

        if ($floatingPayment) {
            // Use the existing payment record
            $floatingPayment->voting_id = $voting_id;
            $floatingPayment->save();
            return response()->json(['success' => true, 'message' => 'Application submitted successfully!']);
        }

        // 3. No floating payment found
        return response()->json([
            'success' => false,
            'message' => 'No active payment found. You must pay the entry fee first.',
            'needs_payment' => true
        ]);
    }

    /**
     * Get list of contestants for a specific round (for AJAX modal)
     */

    public function getAppliedContestants($voting_id)
    {
        $voting = Voting::with(['contestants.region'])->findOrFail($voting_id);

        return response()->json([
            'success' => true,
            'contestants' => $voting->contestants->map(function ($c) {
                return [
                    'name' => $c->name,
                    'image' => $c->image ?? 'https://i.pravatar.cc/150?u=' . $c->id,
                    'region' => $c->region->name ?? 'Global'
                ];
            })
        ]);

    }

    /**
     * Process Payment Action
     */

    public function paymentProcess()
    {
        $user = Auth::user();

        $session = $this->paymentGateway->createCheckoutSession(

            5.00, // $5 Entry Fee
            'usd',
            route('contestant.paymentSuccess'),
            route('contestant.dashboard'), // Back to dashboard if canceled
            ['user_id' => $user->id]

        );

        return redirect($session->url);
    }

    /**
     * Handle Success Payment Action
     */

    //payment
    public function paymentSuccess()
    {
        $user = Auth::user();

        // Update contestant payment status
        $contestant = Contestant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'email' => $user->email,
                'payment_status' => 1,
                'status' => 0,
            ]
        );

        // Check if there's already an UNUSED payment (to prevent double-spend on same session)
        $existingUnusedEntry = \App\Models\VotingContestant::where('contestant_id', $contestant->id)
            ->whereNull('voting_id')
            ->first();

        // Only create entry if they don't have a "floating" payment waiting
        if (!$existingUnusedEntry) {
            \App\Models\VotingContestant::create([
                'voting_id' => null, // Will be assigned when they click "Apply" on a round
                'contestant_id' => $contestant->id,
                'payments' => 5.00, // Entry fee amount
            ]);
        }

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Payment successful! You can now apply for a competition round.');
    }

//  profiles  create
    public function profile()
    {
        $user = Auth::user();
        $contestant = Contestant::where('user_id', $user->id)->first();
        $regions = Region::all();

        return view('contestant.profile.contestant_profile', compact('contestant', 'regions'));
    }


    /**
     * Store Profile Action
     */
    // profiles store.

    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'date_of_birth' => 'required|date|before:today',
            'contact' => 'required|string|max:255',
            'region' => 'nullable',
            'bio' => 'required|string',
        ]);

        $user = Auth::user();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('contestants', $filename, 'public');
            $imagePath = '/storage/' . $path;
        }

        // Update or create contestant
        Contestant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $request->name,
                'image' => $imagePath ?? $user->contestant?->image,
                'date_of_birth' => $request->date_of_birth,
                'contact' => $request->contact,
                'region_id' => $request->region,
                'bio' => $request->bio,
                'email' => $user->email,
                'profile_status' => 1,
                'payment_status' => 1,
                'status' => 0,
            ]
        );

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Profile submitted successfully! Admin will approve your account shortly.');
    }

}
