<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    /**
     * Create a payment session/intent.
     *
     * @param float $amount
     * @param string $currency
     * @param string $successUrl
     * @param string $cancelUrl
     * @param array $metadata
     * @return mixed
     */
    public function createCheckoutSession(float $amount, string $currency, string $successUrl, string $cancelUrl, array $metadata = []);

    /**
     * Create a subscription session/intent.
     *
     * @param float $amount
     * @param string $currency
     * @param string $successUrl
     * @param string $cancelUrl
     * @param array $metadata
     * @return mixed
     */
    public function createSubscriptionSession(float $amount, string $currency, string $successUrl, string $cancelUrl, array $metadata = []);
}
