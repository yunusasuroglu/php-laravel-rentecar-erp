<?php

namespace App\Http\Controllers\Company\Payment;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class PaymentController extends Controller
{
    public function handlePost(Request $request)
    {
        try {
            // Stripe API anahtarını ayarlayın
            Stripe::setApiKey('sk_test_51OIcQ5GvgOyaMf6m293LOOjMhsQ7wDnMbSqmZ0QE6GXl5i3pzBkAIBTZaBwM8ttzTWIG5kRGA25DV3BTqwSJBKGj00EOfnnS5l');

            // PaymentIntent oluşturun
            $paymentIntent = PaymentIntent::create([
                'amount' => 1000, // 10.00 USD
                'currency' => 'usd',
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}