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

        // If already paid, redirect to profile form
        if ($contestant && $contestant->payment_status == 1) {
            return redirect()->route('contestant.profile.create');
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

        // Create or update contestant record
        $contestant = Contestant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'payment_status' => 1,
                'status' => 0, // Pending admin approval after profile creation
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

        // Security check: if not paid, redirect to payment

        if (!$contestant || $contestant->payment_status == 0) {

            return redirect()->route('contestant.onboarding.index');

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
            'region' => 'required|exists:regions,id',
            'bio' => 'required|string',
            'age' => 'required|integer|min:18',
            'image' => 'required|image',
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
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $request->phone,
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
