<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Http\Resources\BidResource;


class BidController extends Controller
{
    public function index ()
    {
        $bids = Bid::orderBy('id')->get();
        return BidResource::collection($bids);
    }

    public function show (Bid $bid)
    {
        return new BidResource($bid);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'bid_amount' => 'required',
            'first_name' => 'required',
            'email' => 'required'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $bid = Bid::create($data);

        return new BidResource($bid);
    }

    public function update (Request $request, Bid $bid)
    {
        $request->validate([
            'bid_amount' => 'required'
        ]);

        $bid->update($request->all());

        return $bid;
    }

    public function destroy (Bid $bid)
    {
        $bid->delete();

        return response()->noContent();
    }
}
