<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OtpLoginMail;
use Carbon\Carbon;

class AuthOtpController extends Controller
{
    // 1. Tampilkan Halaman Login (Custom)
    public function showLoginForm()
    {
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

        // --- CEK PASSWORD DULU ---
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Kata sandi salah.']);
        }

        // --- JIKA PASSWORD BENAR, LANJUT KIRIM OTP ---

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke database (Valid 5 menit agar sesuai resend)
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(1)
        ]);

        // Catat waktu pengiriman untuk timer Resend
        session(['otp_last_sent' => now()]);

        // Kirim Email
        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP.']);
        }

        // Simpan email di session
        session(['otp_email' => $user->email]);

        // Arahkan ke halaman verifikasi
        return redirect()->route('otp.verify');
    }

    // 3. Tampilkan Halaman Input OTP (Dengan Data Timer)
    public function showVerifyForm()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login.otp');
        }

        $user = User::where('email', $email)->first();

        // --- LOGIKA HITUNGAN MUNDUR UNTUK RESEND ---
        $lastSent = session('otp_last_sent'); // Ambil waktu terakhir kirim
        $waitTime = 0; // Default: Tidak perlu menunggu

        if ($lastSent) {
            $diff = now()->diffInSeconds($lastSent); // Selisih detik
            
            // Perbaikan: Gunakan ceil dan int agar angka bulat dan rapi
            if ($diff < 60) {
                $waitTime = (int) ceil(60 - $diff); 
            }
        }

        return view('auth.verify-otp', [
            'expires_at' => $user->otp_expires_at,
            'waitTime' => $waitTime // <-- Kirim variabel ini ke View
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
            
            // Login User
            Auth::login($user);

            // Bersihkan data OTP
            $user->update(['otp' => null, 'otp_expires_at' => null]);
            session()->forget(['otp_email', 'otp_last_sent']); // Bersihkan session

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

    // 5. [BARU] Logika Resend OTP via AJAX
    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Sesi habis, silakan login ulang.'], 401);
        }

        // 1. CEK COOLDOWN (Logika 1 Menit)
        $lastSent = session('otp_last_sent');
        if ($lastSent && now()->diffInSeconds($lastSent) < 60) {
            // Perbaikan: Gunakan ceil dan int agar angka bulat
            $secondsRemaining = (int) ceil(60 - now()->diffInSeconds($lastSent));
            return response()->json([
                'status' => 'error', 
                'message' => "Mohon tunggu $secondsRemaining detik lagi."
            ], 429);
        }

        // 2. Generate & Update OTP
        $user = User::where('email', $email)->first();
        $otp = rand(100000, 999999);
        
        // Kode lama otomatis tertimpa (hangus) saat kita update kolom 'otp'
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(1)
        ]);

        // 3. Update Session (Penting: Reset timer resend jadi 60 detik lagi)
        session(['otp_last_sent' => now()]);

        // 4. Kirim Email
        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim email.'], 500);
        }

        // 5. BERHASIL (Kirim respon JSON sukses)
        return response()->json([
            'status' => 'success', 
            'message' => 'Kode OTP baru berhasil dikirim!'
        ]);
    }
}