<?php

namespace App\Http\Controllers;

use App\Mail\BidAlertMail;
use App\Mail\NewItemMail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index ()
    {
        $products = Product::orderBy('id')->get();
        return ProductResource::collection($products);
    }

    public function show (Product $product)
    {
        return new ProductResource($product);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'seller_id' => 'required',
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'category' => 'required',
            'current_bid' => 'required',
            'increment' => 'required',
            'new_bid' => 'required',
            'stripeid' => 'required'
        ]);
    }

    public function sendBidEmail(Request $data) {
        $this->validate($data, [
            'first_name' => 'required',
            'email' => 'required|email',
            'title' => 'required'
        ]);

        Mail::to($data->email)->send(new BidAlertMail($data));
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $data['creation_time'] = Carbon::now();

        $data['pre_timer'] = Carbon::now()->addHours(6);

        $product = Product::create($data);

        return new ProductResource($product);

        $seller = User::find($data['seller_id']);

        Mail::to($seller->email)->send(new NewItemMail($seller));
    }

    public function update (Request $request, Product $product)
    {
        $product->update([
            'current_bid' => $request->current_bid,
            'bid_level' => $request->bid_level,
            'new_bid' => $request->new_bid,
            'current_timer' => Carbon::now()->addSeconds(60)
        ]);

        return $product;
    }

    public function destroy (Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
