<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import Auth
use Illuminate\Support\Facades\Validator; // Wajib import Validator
use App\Models\User; // Wajib import Model User

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Input tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Cek Kredensial (Email & Password)
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah'
            ], 401);
        }

        // 3. Jika Berhasil, Buat Token
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            
            // INI YANG SERING BIKIN ERROR 500 KALAU MODEL USER BELUM DIEDIT
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);

        } catch (\Exception $e) {
            // Ini akan memberitahu kita apa error aslinya jika 500 lagi
            return response()->json([
                'success' => false,
                'message' => 'Error Server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}