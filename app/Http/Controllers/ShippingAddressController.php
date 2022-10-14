<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Http\Resources\ShippingAddressResource;

class ShippingAddressController extends Controller
{
    public function index ()
    {
        $shipping_addresses = ShippingAddress::orderBy('id')->get();
        return ShippingAddressResource::collection($shipping_addresses);
    }

    public function show (ShippingAddress $shipping_address)
    {
        return new ShippingAddressResource($shipping_address);
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

        $shipping_address = ShippingAddress::create($data);

        return new ShippingAddressResource($shipping_address);
    }

    public function update (Request $request, ShippingAddress $shipping_address)
    {
        $request()->validate([
            'street_1' => 'required',
            'street_2',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'is_primary'
        ]);

        $shipping_address->update($request->all());

        return $shipping_address;
    }

    public function destroy (ShippingAddress $shipping_address)
    {
        $shipping_address->delete();

        return response()->noContent();
    }
}
