<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import Auth
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Wajib import Validator
use Illuminate\Validation\Rule; // <--- Tambahkan ini
use Illuminate\Support\Facades\Storage;
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

            if ($user->role === 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Admin dilarang mengakses API publik.',
                ], 403);
            }
            
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

    // --- TAMBAHKAN FUNGSI INI ---
    public function register(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email tidak boleh kembar
            'password' => 'required|string|min:8|confirmed', // Password harus sama dengan password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'no_telepon' => $request->no_telepon,
            'role' => 'user', // Default role user baru adalah konsumen
        ]);

        // 3. Buat Token (Opsional, agar langsung login)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    // --- AMBIL DATA PROFIL USER LENGKAP ---
    public function getProfile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    // --- UPDATE PROFIL (NAMA, EMAIL, NO TELEPON, ALAMAT, & FOTO) ---
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input (Email Unik kecuali User Sendiri)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'no_telepon' => 'nullable|string|max:20',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto_profil' => 'nullable|image|max:3072',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // 2. Update Data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('no_telepon') && $request->no_telepon !== null) {
            $user->no_telepon = $request->no_telepon;
        } elseif ($request->has('no_wa') && $request->no_wa !== null) {
            $user->no_telepon = $request->no_wa;
        }

        if ($request->has('alamat') && $request->alamat !== null) {
            $user->alamat = $request->alamat;
        }

        // 3. Update Foto Profil
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && !preg_match('#^https?://#i', $user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!',
            'data' => $user
        ]);
    }

    // --- GANTI PASSWORD ---
    public function updatePassword(Request $request)
    {
        // Fleksibel menangani field password atau new_password
        $newPassword = $request->input('new_password', $request->input('password'));
        $confirmPassword = $request->input('new_password_confirmation', $request->input('password_confirmation'));

        $request->merge([
            'new_password' => $newPassword,
            'new_password_confirmation' => $confirmPassword,
        ]);

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = $request->user();

        // 1. Cek apakah password lama benar?
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kata sandi saat ini salah.',
            ], 400);
        }

        // 2. Update Password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diperbarui!',
        ]);
    }

    // --- HAPUS AKUN SECARA PERMANEN ---
    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        // Cabut semua token autentikasi
        $user->tokens()->delete();

        // Hapus foto profil dari storage jika ada
        if ($user->foto_profil && !preg_match('#^https?://#i', $user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        // Hapus record user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Akun Anda berhasil dihapus secara permanen.'
        ]);
    }

    // --- LOGIN VIA GOOGLE (API SINKRON WEB) ---
    public function loginByGoogle(Request $request)
    {
        // 1. Validasi data akun Google
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
            'google_id' => 'required|string',
            'photo_url' => 'nullable|string',
            'foto_profil' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data akun Google tidak valid', 'errors' => $validator->errors()], 422);
        }

        $email = trim($request->email);
        $googleId = trim($request->google_id);
        $name = trim($request->name);
        $avatar = $request->input('photo_url', $request->input('foto_profil'));

        // 2. Cari User berdasarkan Email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Sinkronkan data provider Google sama seperti di web
            $user->provider = 'google';
            $user->provider_id = $googleId;
            if (!empty($avatar) && (empty($user->foto_profil) || str_starts_with($user->foto_profil, 'http'))) {
                $user->foto_profil = $avatar;
            }
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
            }
            $user->save();
        } else {
            // Buat User Baru persis seperti alur Socialite di routes/web.php
            $user = User::create([
                'name' => !empty($name) ? $name : ($request->name ?? explode('@', $email)[0]),
                'email' => $email,
                'provider' => 'google',
                'provider_id' => $googleId,
                'foto_profil' => $avatar,
                'email_verified_at' => now(),
                'role' => 'user',
                'password' => Hash::make($googleId . rand(1000, 9999)),
                'no_telepon' => null,
            ]);
        }

        // 3. Buat Personal Access Token Sanctum untuk sesi mobile
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login dengan Akun Google Berhasil!',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }
}

