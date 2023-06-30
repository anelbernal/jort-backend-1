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
    public function index ()
    {
        $winners = Winner::orderBy('id')->get();
        return WinnerResource::collection($winners);
    }

    public function show (Winner $winner)
    {
        return new WinnerResource($winner);
    }

    protected function validateRequest ()
    {
        return request()->validate([
            'payment_status' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
    }

    public function store (Request $request)
    {
        $data = $this->validateRequest();

        $winner = Winner::create($data);

        return new WinnerResource($winner);

        $winner_info = User::find($winner['user_id']);

        Mail::to($winner_info->email)->send(new WinnerMail($winner));
    }

    public function update (Request $request, Winner $winner)
    {
        $request()->validate([
            'payment_status' => 'required'
        ]);

        $winner->update($request->all());

        return $winner;
    }

    public function destroy (Winner $winner)
    {
        $winner->delete();

        return response()->noContent();
    }
}
