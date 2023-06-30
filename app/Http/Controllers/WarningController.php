<?php

namespace App\Http\Controllers;

use App\Mail\WarningMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WarningController extends Controller
{
    public function sendMail(Request $data) {
        $this->validate($data, [
            'first_name' => 'required|min:4',
            'last_name' => 'required|min:4',
            'email' => 'required|email',
        ]);

        Mail::to($data->email)->send(new WarningMail($data));
    }
}
