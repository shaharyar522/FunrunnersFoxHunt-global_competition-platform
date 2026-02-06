<?php

namespace App\Http\Controllers\Contestant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\Region;
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
        $votingContestant = \App\Models\VotingContestant::where('contestant_id', $contestant->id)
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

        // 5. State: Fully registered
        $current_date = now()->format('M d, Y');
        $voting_data = \App\Models\VotingContestant::with('voting')->where('contestant_id', $contestant->id)->first();
        
        // Count contestants in the SAME round as this contestant
        $total_contestants = 0;
        if ($voting_data && $voting_data->voting_id) {
            $total_contestants = \App\Models\VotingContestant::where('voting_id', $voting_data->voting_id)->count();
        }
        
        $applying_contestants = Contestant::where('status', 0)->count();
        
        return view('contestant.dashboard', compact('contestant', 'total_contestants', 'current_date', 'voting_data', 'applying_contestants'));

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

    public function paymentSuccess()
    {
        $user = Auth::user();

        // Update contestant payment status
        $contestant = Contestant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 1,
                'status' => 0,
            ]
        );

        // Check if entry already exists in voting_contestants (prevent duplicate payments)
        $existingEntry = \App\Models\VotingContestant::where('contestant_id', $contestant->id)
            ->limit(1)
            ->first();

        // Only create entry if it doesn't exist (one-time payment)
        if (!$existingEntry) {
            \App\Models\VotingContestant::create([
                'voting_id' => null, // Will be assigned when admin creates voting round
                'contestant_id' => $contestant->id,
                'payments' => 5.00, // Entry fee amount
            ]);
        }

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Payment successful! Please complete your profile');
    }


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
