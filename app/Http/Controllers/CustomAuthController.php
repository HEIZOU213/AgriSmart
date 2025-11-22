<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <-- Penting untuk validasi unik saat update
use Illuminate\Validation\Rules\Password; // <-- Penting untuk validasi password

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
            'role' => 'konsumen', // Default role konsumen
        ]);

        Auth::login($user);
        // Setelah daftar, arahkan ke Marketplace (Produk) sesuai permintaan awal Anda
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'petani') return redirect()->route('petani.dashboard');
            
            // Konsumen diarahkan ke Homepage (Beranda) sesuai permintaan terakhir
            // (Atau bisa ganti ke 'produk.index' jika ingin ke marketplace)
            return redirect()->route('homepage'); 
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

    // --- [PROFIL MANAJEMEN] ---
    
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
            // Validasi email unik, tapi abaikan ID user sendiri
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:255'],
            // Tambahkan validasi foto profil jika fitur upload foto aktif
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        // Logika Upload Foto (Jika ada di form)
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $path;
        }

        // Jika email diubah, reset verifikasi
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