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

    public function resetPassword(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $resetData = DB::table('password_resets')->where('token', $token)->first();

        if (!$resetData) {
            return response()->json(['error' => 'Invalid or expired token'], 401);
        }

        // Update password for the user
        DB::table('users')
            ->where('email', $resetData->email)
            ->update(['password' => Hash::make($request->input('password'))]);

        // Remove the reset token from the database
        DB::table('password_resets')->where('token', $token)->delete();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
