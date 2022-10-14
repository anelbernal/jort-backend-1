<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentIntent;
use App\Http\Resources\PaymentIntentResource;


class PaymentIntentController extends Controller
{
    public function index ()
    {
        $payment_intents = PaymentIntent::orderBy('id')->get();
        return PaymentIntentResource::collection($payment_intents);
    }

    public function show (PaymentIntent $payment_intent)
    {
        return new PaymentIntentResource($payment_intent);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'status' => 'required'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $payment_intent = PaymentIntent::create($data);

        return new PaymentIntentResource($payment_intent);
    }

    public function update (Request $request, PaymentIntent $payment_intent)
    {
        $request()->validate([
            'status' => 'required'
        ]);

        $payment_intent->update($request->all());

        return $payment_intent;
    }

    public function destroy (PaymentIntent $payment_intent)
    {
        $payment_intent->delete();

        return response()->noContent();
    }
}
