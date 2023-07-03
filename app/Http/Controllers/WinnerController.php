<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WinnerMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Winner;
use App\Http\Resources\WinnerResource;
use App\Models\User;

class WinnerController extends Controller
{
    public function index()
    {
        $winners = Winner::orderBy('id')->paginate(10);
        return WinnerResource::collection($winners);
    }

    public function show(Winner $winner)
    {
        return new WinnerResource($winner);
    }

    protected function validateRequest()
    {
        return request()->validate([
            'payment_status' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest();

        $winner = Winner::create($data);

        $this->sendWinnerEmail($winner);

        return new WinnerResource($winner);
    }

    public function update(Request $request, Winner $winner)
    {
        $request->validate([
            'payment_status' => 'required'
        ]);

        $winner->update($request->only('payment_status'));

        return new WinnerResource($winner);
    }

    public function destroy(Winner $winner)
    {
        $winner->delete();

        return response()->noContent();
    }

    protected function sendWinnerEmail(Winner $winner)
    {
        $winner_info = User::find($winner->user_id);

        try {
            Mail::to($winner_info->email)->send(new WinnerMail($winner));
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error, return an error response)
            // You can customize this based on your application's error handling strategy
            // For example:
            \Log::error('Failed to send winner email: ' . $e->getMessage());
            // return response()->json(['message' => 'Failed to send winner email'], 500);
        }
    }
}