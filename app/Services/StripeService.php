<?php
namespace App\Services;
use App\Interfaces\PaymentGatewayInterface;
use Stripe\StripeClient;

class StripeService implements PaymentGatewayInterface
{
    

    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
    }

    public function createCheckoutSession(float $amount, string $currency, string $successUrl, string $cancelUrl, array $metadata = [])
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Contestant Entry Fee',
                        'description' => 'One-time registration fee for Funrunners Fox Hunt',
                    ],
                    'unit_amount' => $amount * 100, // Stripe uses cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => $metadata,
        ]);
    }

    public function createSubscriptionSession(float $amount, string $currency, string $successUrl, string $cancelUrl, array $metadata = [])
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Monthly Membership',
                        'description' => 'Monthly voting membership for Funrunners Fox Hunt',
                    ],
                    'unit_amount' => $amount * 100, // Stripe uses cents
                    'recurring' => [
                        'interval' => 'month',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => $metadata,
        ]);
    }

}
