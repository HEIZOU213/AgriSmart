<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MidtransController extends Controller
{
    /**
     * Tampilkan form pengaturan Midtrans Pekebun.
     */
    public function index()
    {
        $user = Auth::user();

        return view('petani.midtrans.index', compact('user'));
    }

    /**
     * Simpan / Perbarui kredensial Midtrans Pekebun.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'midtrans_server_key' => 'nullable|string|max:255',
            'midtrans_client_key' => 'nullable|string|max:255',
            'midtrans_merchant_id' => 'nullable|string|max:255',
            'midtrans_is_production' => 'nullable|boolean',
        ]);

        $user->update([
            'midtrans_server_key' => $validated['midtrans_server_key'] ?? null,
            'midtrans_client_key' => $validated['midtrans_client_key'] ?? null,
            'midtrans_merchant_id' => $validated['midtrans_merchant_id'] ?? null,
            'midtrans_is_production' => $request->has('midtrans_is_production'),
        ]);

        return redirect()->route('petani.midtrans.index')
            ->with('success', 'Konfigurasi Midtrans akun Anda berhasil disimpan! Pembayaran produk Anda kini langsung diteruskan ke rekening/akun Midtrans Anda.');
    }
}
