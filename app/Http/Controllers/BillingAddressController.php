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

    public function userIndex ($id)
    {
        $billing_addresses = BillingAddress::orderBy('id')->where('user_id', $id)->get();
        return BillingAddressResource::collection($billing_addresses);
    }

    public function show (BillingAddress $billing_address)
    {
        return new BillingAddressResource($billing_address);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'user_id' => 'required',
            'street_1' => 'required',
            'street_2',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'is_primary' => 'required'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $billing_address = BillingAddress::create($data);

        return new BillingAddressResource($billing_address);
    }

    public function update (Request $request, BillingAddress $billing_address)
    {
        $billing_address->update([
            'street_1' => $request->street_1,
            'street_2' => $request->street_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'is_primary' => $request->is_primary
        ]);

        return $billing_address;
    }

    public function destroy (BillingAddress $billing_address)
    {
        $billing_address->delete();

        return response()->noContent();
    }
}
