<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $resetLink = url("/password-reset/$token");

        Mail::send('emails.password_reset', ['resetLink' => $resetLink, 'email' => $email], function ($message) use ($email) {
            $message->to($email)->subject('Reset Password');
        });

        return response()->json(['message' => 'Password reset link sent successfully']);
    }
}
