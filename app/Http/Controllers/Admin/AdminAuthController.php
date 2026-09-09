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

        // 2. Kredensial khusus ADMIN
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // 3. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Kredensial tidak cocok atau akun bukan admin.',
        ]);
    }
}

