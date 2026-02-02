<?php

namespace App\Http\Controllers\Contestant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Contestant;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class ContestantOnboardingController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Show the payment requirement page.
     */
    public function index()
    {
        
        $user = Auth::user();
        $contestant = Contestant::where('user_id', $user->id)->first();

        // 1. If profile already complete, go to dashboard
        if ($contestant && $contestant->profile_status == 1) {
            return redirect()->route('contestant.dashboard');
        }

        // 2. If already paid but profile incomplete, redirect to profile setup
        if ($contestant && $contestant->payment_status == 1) {
            return redirect()->route('contestant.profile.setup');
        }

        return view('contestant.onboarding.index');

    }

    /**
     * Process the payment (Stripe or any gateway)
     */
    public function processPayment()
    {
        $user = Auth::user();

        $session = $this->paymentGateway->createCheckoutSession(

            5.00, // $5 Entry Fee
            'usd',
            route('contestant.onboarding.success'),
            route('contestant.onboarding.index'),
            ['user_id' => $user->id]

        );

        return redirect($session->url);
    }

    /**
     * Handle successful payment
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

        return redirect()->route('contestant.profile.setup')
            ->with('success', 'Payment successful! Please complete your profile');
    }


    /**
     * Show the profile creation form
     */
    public function showProfileForm()
    {
        $user = Auth::user();

        $contestant = Contestant::where('user_id', $user->id)->first();

        // 1. If not paid, redirect to payment
        if (!$contestant || $contestant->payment_status == 0) {

            return redirect()->route('contestant.onboarding.index');

        }

        // 2. If profile already complete, go to dashboard
        if ($contestant->profile_status == 1) {

            return redirect()->route('contestant.dashboard');

        }

        // Load regions for dropdown
        $regions = Region::all();

        return view('contestant.onboarding.profile', compact('contestant', 'regions'));
    }

    /**
     * Store the contestant profile
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
                'profile_status' => 1, // Profile is now complete
                'payment_status' => 1,
                'status' => 0, // Pending admin approval
            ]
        );

        return redirect()->route('contestant.dashboard')
            ->with('success', 'Profile submitted successfully! Admin will approve your account shortly.');
    }
}
