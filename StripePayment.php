<?php
require_once 'stripe/init.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class DonationProcessor
{
    private $apiKey;
    private $successUrl;
    private $cancelUrl;

    public function __construct($apiKey, $successUrl, $cancelUrl)
    {
        $this->apiKey = $apiKey;
        $this->successUrl = $successUrl;
        $this->cancelUrl = $cancelUrl;

        Stripe::setApiKey($this->apiKey);
    }

    public function createCheckoutSession($donationAmount, $currency = 'gbp')
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => 'Donation to Dundee Muslim Community Trust',
                        ],
                        'unit_amount' => $donationAmount * 100, // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $this->successUrl. '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $this->cancelUrl,
            ]);

            return $session;
        } catch (\Exception $e) {
            throw new Exception('Payment Processing Error: ' . $e->getMessage());
        }
    }
}
