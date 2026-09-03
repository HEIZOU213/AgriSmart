<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Mail\OtpResetPasswordMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form untuk memasukkan email.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim OTP ke email user.
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke tabel users
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        // Kirim Email
        try {
            Mail::to($user->email)->send(new OtpResetPasswordMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email OTP. Silakan coba lagi.'])->withInput();
        }

        // Simpan email di session untuk tahap verifikasi
        session(['reset_email' => $user->email]);

        return redirect()->route('password.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Tampilkan form verifikasi OTP.
     */
    public function showVerifyForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-reset-otp');
    }

    /**
     * Verifikasi OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi habis, silakan ulangi proses.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Pengguna tidak ditemukan.']);
        }

        // Cek validitas OTP
        if ($user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta ulang.'])->withInput();
        }

        // OTP valid, beri izin untuk reset password
        session(['can_reset_password' => true]);

        // Opsional: Hapus OTP setelah digunakan (keamanan tambahan)
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return redirect()->route('password.reset')->with('success', 'Verifikasi berhasil. Silakan buat kata sandi baru.');
    }

    /**
     * Tampilkan form pembuatan kata sandi baru.
     */
    public function showResetForm()
    {
        if (!session()->has('can_reset_password') || !session()->has('reset_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses ditolak. Silakan verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.reset-password');
    }

    /**
     * Simpan kata sandi baru.
     */
    public function resetPassword(Request $request)
    {
        if (!session()->has('can_reset_password') || !session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Bersihkan session
        session()->forget(['reset_email', 'can_reset_password']);

        return redirect()->route('login')->with('success', 'Kata sandi berhasil direset! Silakan masuk dengan kata sandi baru.');
    }
}
