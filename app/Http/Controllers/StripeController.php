<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $request->item['title'],
                    ],
                    'unit_amount' => $request->item['price'],
                ],
                'quantity' => 1,
            ]],
            'payment_intent_data' => [
                'application_fee_amount' => $request->application_fee,
                'transfer_data' => ['destination' => $request->stripe_id],
            ],
            'mode' => 'payment',
            'success_url' => 'https://jortinc.com/bid',
            'cancel_url' => 'https://jortinc.com/bid',
        ]);

        return response()->json($checkout_session);
    }

    public function stripeExpressAccount (Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $expressAccount = $stripe->accounts->create([
            'country' => 'US',
            'type' => 'express',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'cashapp_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'individual' => [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
            ],
            'default_currency' => 'USD',
        ]);
        
        $stripeurl = $stripe->accountLinks->create([
            'account' => $expressAccount->id,
            'refresh_url' => 'https://jortinc.com/terms?stripeFail=true',
            'return_url' => 'https://jortinc.com/sell',
            'type' => 'account_onboarding',
        ]);

        $response = [
            'express_account_info' => $expressAccount,
            'stripe_url' => $stripeurl,
        ];

        return response($response, 200);
    }

    public function stripeConnect (Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $response = $stripe->accounts->retrieve($request->stripekey, []);

        return response($response, 200);
    }

    public function updateSeller (Request $request, User $user)
    {
        $user->update([
            'stripeid' => $request->stripeid
        ]);

        return $user;
    }
    
}