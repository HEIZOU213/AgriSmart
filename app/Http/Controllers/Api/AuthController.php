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
            'role' => 'konsumen', // Default role user baru adalah konsumen
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

    // --- UPDATE PROFIL (NAMA & FOTO) ---
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input (Menggunakan Rule agar Validasi Email User Sendiri Diabaikan)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // Artinya: Cek unik di tabel 'users', TAPI abaikan ID user yang sedang login
                Rule::unique('users')->ignore($user->id),
            ],
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        // Jika validasi gagal, kirim pesan error detail
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(), // Ambil pesan error pertama
            ], 422);
        }

        // 2. Update Data (Jika lolos validasi)
        $user->name = $request->name;
        $user->email = $request->email;

        // 3. Update Foto
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada (agar storage tidak penuh)
            if ($user->foto_profil && !preg_match('#^https?://#i', $user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan foto baru
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
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // confirmed = butuh field new_password_confirmation
        ]);

        $user = $request->user();

        // 1. Cek apakah password lama benar?
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah.',
            ], 400);
        }

        // 2. Update Password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui!',
        ]);
    }

    // --- LOGIN VIA GOOGLE (API) ---
    public function loginByGoogle(Request $request)
    {
        // 1. Validasi data yang dikirim Flutter
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
            'google_id' => 'required|string', // ID unik dari Google
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data Google tidak valid'], 422);
        }

        // 2. Cari User berdasarkan Email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // A. Jika user sudah ada, update google_id-nya (opsional) & Login
            // $user->update(['google_id' => $request->google_id]); // Jika punya kolom google_id
        } else {
            // B. Jika belum ada, Buat User Baru (Register Otomatis)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->google_id . rand(1000,9999)), // Password acak
                'role' => 'konsumen',
                'no_telepon' => null, // Nanti user bisa update sendiri
                // 'google_id' => $request->google_id, // Aktifkan jika ada kolom ini
            ]);
        }

        // 3. Buat Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Google Berhasil',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }
}