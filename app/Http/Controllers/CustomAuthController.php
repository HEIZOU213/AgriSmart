<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Tambahkan ini
use Illuminate\Validation\Rules\Password; // <-- Tambahkan ini

class CustomAuthController extends Controller
{
    // --- REGISTER ---
    public function showRegister()
    {
        return view('auth.custom-register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'konsumen',
        ]);

        Auth::login($user);
        return redirect()->route('produk.index');
    }

    // --- LOGIN ---
    public function showLogin()
    {
        return view('auth.custom-login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) { // Tambahkan 'remember'
            $request->session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'petani') return redirect()->route('petani.dashboard');
            return redirect()->route('homepage'); // Konsumen langsung ke produk
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- [KODE BARU] PROFIL MANAJEMEN ---
    
    // 1. Tampilkan Halaman Edit Profil
    public function showProfile()
    {
        return view('auth.custom-profile', [
            'user' => Auth::user()
        ]);
    }

    // 2. Update Info Profil (Nama, Email, dll)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        // Jika email diubah, reset verifikasi (jika Anda pakai verifikasi)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        return back()->with('status', 'profile-updated');
    }

    // 3. Update Password
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}