<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::orderBy('id')->paginate(10);
        return PaymentMethodResource::collection($payment_methods);
    }

    public function show(PaymentMethod $payment_method)
    {
        return new PaymentMethodResource($payment_method);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'last4' => 'required'
        ]);
    }

    public function store()
    {
        $data = $this->validateRequest();

        $payment_method = PaymentMethod::create($data);

        return new PaymentMethodResource($payment_method);
    }

    public function update(Request $request, PaymentMethod $payment_method)
    {
        $request->validate([
            'last4' => 'required'
        ]);

        $payment_method->update($request->all());

        return $payment_method;
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();

        return response()->noContent();
    }
}