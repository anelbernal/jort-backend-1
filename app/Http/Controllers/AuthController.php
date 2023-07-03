<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function update(Request $request, Bid $bid)
{
    $request->validate([
        'bid_amount' => 'required'
    ]);

    $bid->update($request->all());

    return $bid;
}

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->email)->first();
            if ($findUser) {
                $response = [
                    'user' => $findUser,
                    201
                ];
            } else {
                $newUser = User::create([
                    'email' => $user->email,
                    'password' => bcrypt($user->name . 'googleAuth'),
                    'photo_url' => $user->avatar
                ]);
                $response = [
                    'user' => $newUser,
                    201,
                ];
            }
        } catch (Exception $e) {
            $response = ['message' => 'Error. Try again.', 401];
        }

        return response($response);
    }

    public function relogin(Request $request, User $user)
    {
        $user = User::where('remember_token', $request['token'])->first();

        return $user;
    }
}