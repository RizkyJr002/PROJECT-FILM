<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $otp = $request->input('otp');
        $resetData = DB::table('password_resets')->where('otp', $otp)->first();

        if (!$resetData || $resetData->otp !== $request->input('otp')) {
            return response()->json(['error' => 'Invalid or expired token or OTP'], 401);
        }

        DB::table('users')
            ->where('email', $resetData->email)
            ->update(['password' => Hash::make($request->input('password'))]);

        DB::table('password_resets')->where('otp', $otp)->delete();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
