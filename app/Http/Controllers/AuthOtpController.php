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
    // 1. Tampilkan Halaman Login
    public function showLoginForm()
    {
        return view('auth.custom-login');
    }

    // 2. PROSES LOGIN
    public function loginWithPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.exists' => 'Email ini belum terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek Password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Kata sandi salah.']);
        }

        // --- 🛡️ SATPAM (LOGIKA KEAMANAN ADMIN) ---
        // Akun Admin DILARANG masuk lewat form login umum / OTP
        if ($user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Akun Admin DILARANG masuk lewat sini! Gunakan jalur khusus Master Control.',
            ])->withInput();
        }

        // --- LOGIKA OTP ENABLED/DISABLED ---
        if (!filter_var(config('auth.otp_enabled', false), FILTER_VALIDATE_BOOLEAN)) {
            // Jika OTP dimatikan, langsung login
            Auth::login($user);
            $request->session()->regenerate();
            return $this->redirectBasedOnRole($user);
        }

        // --- JIKA OTP AKTIF, KIRIM OTP ---
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        session(['otp_last_sent' => now(), 'otp_email' => $user->email]);

        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email OTP login: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email OTP: ' . $e->getMessage()]);
        }

        return redirect()->route('otp.verify');
    }

    // 3. Tampilkan Halaman Input OTP
    public function showVerifyForm()
    {
        // Proteksi jika OTP dimatikan tapi user mencoba akses manual route ini
        if (!filter_var(config('auth.otp_enabled', false), FILTER_VALIDATE_BOOLEAN)) {
            return redirect()->route('login');
        }

        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();

        return view('auth.verify-otp', [
            'expires_at' => $user->otp_expires_at,
            'waitTime' => 0 // Tombol resend langsung aktif
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
            return redirect()->route('login')->withErrors(['email' => 'Sesi habis.']);
        }

        // Cek OTP dan Masa Berlaku
        if ($user->otp == $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            
            Auth::login($user);

            // Bersihkan data
            $user->update(['otp' => null, 'otp_expires_at' => null]);
            session()->forget(['otp_email', 'otp_last_sent']);

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors(['otp' => 'Kode salah atau sudah kedaluwarsa.']);
    }

    // 5. Resend OTP via AJAX
    public function resendOtp()
    {
        $email = session('otp_email');
        if (!$email || !filter_var(config('auth.otp_enabled', false), FILTER_VALIDATE_BOOLEAN)) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 401);
        }

        $user = User::where('email', $email)->first();
        $otp = rand(100000, 999999);
        
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        try {
            Mail::to($user->email)->send(new OtpLoginMail($otp));
            return response()->json(['status' => 'success', 'message' => 'Kode OTP baru berhasil dikirim!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim email.'], 500);
        }
    }

    /**
     * Helper untuk redirect berdasarkan role (Agar DRY - Don't Repeat Yourself)
     */
    private function redirectBasedOnRole($user)
    {
        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'pekebun'   => redirect()->route('portal.index'), // <-- Diubah ke Portal
            'user' => redirect()->route('homepage'),
            default    => redirect()->route('homepage'),
        };
    }
}

