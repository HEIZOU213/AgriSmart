<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

// --- TAMBAHAN BARU (Wajib untuk fitur OTP Register) ---
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpLoginMail;
use Carbon\Carbon;
// ------------------------------------------------------

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

        // 1. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'konsumen', // Default role konsumen
        ]);

        // --- PERUBAHAN: LANGSUNG KIRIM OTP (Jangan Login Otomatis) ---

        // 2. Generate OTP
        $otp = rand(100000, 999999);

        // 3. Simpan OTP ke User
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // 4. Kirim Email (Pakai Try-Catch agar aman)
        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
        } catch (\Exception $e) {
            // Jika gagal kirim email, biarkan lanjut (user bisa minta ulang nanti)
        }

        // 5. Simpan email di session agar halaman verifikasi tahu siapa ini
        session(['otp_email' => $user->email]);

        // 6. Redirect ke Halaman Masukkan OTP
        return redirect()->route('otp.verify')->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
    }

    // --- LOGIN (TIDAK DIUBAH, SESUAI KODE ASLI) ---
    public function showLogin()
    {
        return view('auth.custom-login');
    }

    public function processLogin(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba Login (Cek Email & Password di Database)
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Ambil status checkbox "Ingat Saya"

        if (Auth::attempt($credentials, $remember)) {
            
            // --- 🛡️ SATPAM (LOGIKA KEAMANAN TAMBAHAN) ---
            
            // Cek Role User yang baru saja login
            $user = Auth::user();

            // Jika ternyata dia adalah ADMIN
            if ($user->role === 'admin') {
                
                // TENDANG KELUAR (Logout Paksa)
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Kembalikan ke form login dengan pesan error
                return back()->withErrors([
                    'email' => 'Akun Admin DILARANG masuk lewat sini! Gunakan jalur khusus.',
                ])->withInput(); // Biar emailnya tidak hilang
            }

            // --- 🛡️ AKHIR LOGIKA SATPAM ---


            // 3. Jika bukan Admin (Berarti Petani/Konsumen), izinkan lanjut
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 4. Jika Email/Password Salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // --- LOGOUT (TIDAK DIUBAH) ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- [PROFIL MANAJEMEN] (TIDAK DIUBAH) ---
    
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