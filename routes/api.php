<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentIntentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\WinnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/bids', [BidController::class, 'index']);
Route::get('/bids/{bid}', [BidController::class, 'show']);
Route::post('/bids', [BidController::class, 'store']);
Route::put('/bids/{bid}', [BidController::class, 'update']);
Route::delete('/bids/{bid}', [BidController::class, 'destroy']);

Route::get('/billing-addresses', [BillingAddressController::class, 'index']);
Route::get('/billing-addresses/{billing_address}', [BillingAddressController::class, 'show']);
Route::post('/billing-addresses', [BillingAddressController::class, 'store']);
Route::put('/billing-addresses/{billing_address}', [BillingAddressController::class, 'update']);
Route::delete('/billing-addresses/{billing_address}', [BillingAddressController::class, 'destroy']);

Route::get('/medias', [MediaController::class, 'index']);
Route::get('/medias/{media}', [MediaController::class, 'show']);
Route::post('/medias', [MediaController::class, 'store']);
Route::put('/medias/{media}', [MediaController::class, 'update']);
Route::delete('/medias/{media}', [MediaController::class, 'destroy']);

Route::get('/payment-intents', [PaymentIntentController::class, 'index']);
Route::get('/payment-intents/{payment_intent}', [PaymentIntentController::class, 'show']);
Route::post('/payment-intents', [PaymentIntentController::class, 'store']);
Route::put('/payment-intents/{payment_intent}', [PaymentIntentController::class, 'update']);
Route::delete('/payment-intents/{payment_intent}', [PaymentIntentController::class, 'destroy']);

Route::get('/payment-methods', [PaymentMethodController::class, 'index']);
Route::get('/payment-methods/{payment_method}', [PaymentMethodController::class, 'show']);
Route::post('/payment-methods', [PaymentMethodController::class, 'store']);
Route::put('/payment-methods/{payment_method}', [PaymentMethodController::class, 'update']);
Route::delete('/payment-methods/{payment_method}', [PaymentMethodController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/shipping-addresses', [ShippingAddressController::class, 'index']);
Route::get('/shipping-addresses/{shipping_address}', [ShippingAddressController::class, 'show']);
Route::post('/shipping-addresses', [ShippingAddressController::class, 'store']);
Route::put('/shipping-addresses/{shipping_address}', [ShippingAddressController::class, 'update']);
Route::delete('/shipping-addresses/{shipping_address}', [ShippingAddressController::class, 'destroy']);

Route::get('/winners', [WinnerController::class, 'index']);
Route::get('/winners/{winner}', [WinnerController::class, 'show']);
Route::post('/winners', [WinnerController::class, 'store']);
Route::put('/winners/{winner}', [WinnerController::class, 'update']);
Route::delete('/winners/{winner}', [WinnerController::class, 'destroy']);
