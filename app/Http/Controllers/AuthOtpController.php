<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; // Penting untuk cek password
use App\Models\User;
use App\Mail\OtpLoginMail;
use Carbon\Carbon;

class AuthOtpController extends Controller
{
    // 1. Tampilkan Halaman Login (Custom)
    public function showLoginForm()
    {
        // Menggunakan view custom login Anda
        return view('auth.custom-login'); 
    }

    // 2. PROSES LOGIN (Cek Password -> Kirim OTP)
    public function loginWithPassword(Request $request)
    {
        // Validasi Input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => 'Email ini belum terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Ambil data user
        $user = User::where('email', $request->email)->first();

        // --- LOGIKA BARU: CEK PASSWORD DULU ---
        if (!Hash::check($request->password, $user->password)) {
            // Jika password salah, kembalikan ke login dengan error
            return back()->withErrors(['password' => 'Kata sandi salah.']);
        }

        // --- JIKA PASSWORD BENAR, LANJUT KIRIM OTP ---
        
        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke database (Valid 2 menit)
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(2)
        ]);

        // Kirim Email
        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP.']);
        }

        // Simpan email di session untuk halaman selanjutnya
        session(['otp_email' => $user->email]);

        // Arahkan ke halaman verifikasi
        return redirect()->route('otp.verify');
    }

    // 3. Tampilkan Halaman Input OTP
    public function showVerifyForm()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login.otp');
        }

        $user = User::where('email', $email)->first();

        return view('auth.verify-otp', [
            'expires_at' => $user->otp_expires_at
        ]);
    }

    // 4. Proses Verifikasi Kode OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $email = session('otp_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login.otp')->withErrors(['email' => 'Sesi habis.']);
        }

        // Cek OTP dan Waktu
        if ($user->otp == $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            
            // Login User (Akhirnya!)
            Auth::login($user);

            // Bersihkan data OTP
            $user->update(['otp' => null, 'otp_expires_at' => null]);
            session()->forget('otp_email');

            // Redirect sesuai Role
            switch ($user->role) {
                case 'admin': return redirect()->route('admin.dashboard');
                case 'petani': return redirect()->route('petani.dashboard');
                case 'konsumen': return redirect()->route('homepage');
                default: return redirect()->route('homepage');
            }
        }

        return back()->withErrors(['otp' => 'Kode salah atau sudah kedaluwarsa.']);
    }
}