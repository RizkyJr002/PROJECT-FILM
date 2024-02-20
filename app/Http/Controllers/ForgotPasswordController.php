<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $email = $request->input('email');
        $token = Str::random(60);
        $otp   = rand(100000, 999999);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'otp'   => $otp,
        ]);

        $resettoken = $token;
        $resetotp = $otp;

        Mail::send('emails.password_reset', ['resettoken' => $resettoken, 'resetotp' => $resetotp, 'email' => $email], function ($message) use ($email) {
            $message->to($email)->subject('Reset Password');
        });

        return response()->json(['message' => 'Kode OTP berhasil dikirim ke email anda']);
    }
}
