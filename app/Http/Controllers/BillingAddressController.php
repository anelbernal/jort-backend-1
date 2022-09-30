<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Http\Resources\BillingAddressResource;

class BillingAddressController extends Controller
{
    public function index ()
    {
        $billing_addresses = BillingAddress::orderBy('id')->get();
        return BillingAddressResource::collection($billing_addresses);
    }

    public function show (BillingAddress $billing_address)
    {
        return new BillingAddressResource($billing_address);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'street_1' => 'required',
            'street_2',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'is_primary'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $billing_address = BillingAddress::create($data);

        return new BillingAddressResource($billing_address);
    }

    public function update (BillingAddress $billing_address)
    {
        $data = $this->validateRequest();

        $billing_address->update($data);

        return new BillingAddressResource($billing_address);
    }

    public function destroy (BillingAddress $billing_address)
    {
        $billing_address->delete();

        return response()->noContent();
    }
}
