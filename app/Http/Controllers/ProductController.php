<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;


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
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'category' => 'required',
            'current_bid' => 'required',
            'increment' => 'required'
        ]);
    }

    public function store ()
    {
        $data = $this->validateRequest();

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update (Request $request, Product $product)
    {
        $request()->validate([
            'title' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'category' => 'required',
            'current_bid' => 'required',
            'increment' => 'required'
        ]);

        $product->update($request->all());

        return $product;
    }

    public function destroy (Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
