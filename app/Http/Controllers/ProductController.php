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
    public function index()
    {
        $products = Product::orderBy('id')->get();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    protected function validateRequest()
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

    public function sendBidEmail(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'email' => 'required|email',
            'title' => 'required'
        ]);

        Mail::to($validatedData['email'])->send(new BidAlertMail($validatedData));
    }

    public function store()
    {
        $data = $this->validateRequest();

        $data['creation_time'] = Carbon::now();
        $data['pre_timer'] = Carbon::now()->addHours(6);

        $product = Product::create($data);

        $seller = User::findOrFail($data['seller_id']);

        Mail::to($seller->email)->send(new NewItemMail($seller));

        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'current_bid' => 'required',
            'bid_level' => 'required',
            'new_bid' => 'required'
        ]);

        $product->update([
            'current_bid' => $validatedData['current_bid'],
            'bid_level' => $validatedData['bid_level'],
            'new_bid' => $validatedData['new_bid'],
            'current_timer' => Carbon::now()->addSeconds(60)
        ]);

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
