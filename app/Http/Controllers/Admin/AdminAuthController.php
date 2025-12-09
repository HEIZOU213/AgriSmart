<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek Kredensial & Cek Role
        // Asumsi kamu punya kolom 'role' di tabel users
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Cek apakah dia benar-benar ADMIN
            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            } else {
                // Kalau login berhasil tapi dia cuma Petani, tendang keluar
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses ke area ini.',
                ]);
            }
        }

        // 3. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok.',
        ]);
    }
}