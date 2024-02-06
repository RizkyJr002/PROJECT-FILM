<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $data = DB::table('users')
                ->where('level','=','user')
                ->get();
        return response()->json([
            'message' => 'Berhasil menampilkan user',
            'success' => true,
            'data' => $data
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'required',
            'no_hp' => 'required|unique:users',
            'jk' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $gambar = $request->file('gambar');
        $gambar->storeAs('public/posts', $gambar->hashName());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gambar' => $gambar->hashName(),
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jk' => $request->jk,
            'level' => 'user'
        ]);

        return response()->json([
            'message' => 'Registrasi Sukses',
            'success' => true,
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau Password Salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $level = User::where('level', '=', 'admin');

        $token = $user->createToken('auth_token')->plainTextToken;

        switch ($user->level) {
            case 'admin':
                return response()->json([
                    'message' => 'Anda login sebagai admin',
                    'success' => true,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
                break;
            
            default:
            return response()->json([
                'message' => 'Anda login sebagai user',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
                break;
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout sukses'
        ]);
    }
}
