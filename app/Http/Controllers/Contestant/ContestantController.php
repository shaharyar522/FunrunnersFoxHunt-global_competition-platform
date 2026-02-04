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

        // 2. State: Unpaid
        if ($contestant->payment_status == 0) {

            return view('contestant.payment.payment_required');
        }

        // 3. State: Paid but Profile Incomplete
        if ($contestant->profile_status == 0) {

            $regions = Region::all();

            return view('contestant.profile.contestant_profile', compact('contestant', 'regions'));
        }

        // 4. State: Fully registered
        return view('contestant.dashboard', compact('contestant'));
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

        Contestant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 1,
                'status' => 0,
            ]
        );

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Payment successful! Please complete your profile');
    }


    /**
     * Store Profile Action
     */
    public function storeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image',
            'age' => 'required|integer|min:18',
            'contact' => 'required|string|max:255',
            'region' => 'required|exists:regions,id',
            'bio' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Update user password
        $user->update([
            'password' => bcrypt($request->password),
        ]);

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
                'email' => $user->email,
                'contact' => $request->contact,
                'region_id' => $request->region,
                'image' => $imagePath,
                'profile_status' => 1,
                'payment_status' => 1,
                'status' => 0,
            ]
        );

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Profile submitted successfully! Admin will approve your account shortly.');
    }
}
