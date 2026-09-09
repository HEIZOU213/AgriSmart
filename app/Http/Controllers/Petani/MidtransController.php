<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

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

        $serverKey = isset($validated['midtrans_server_key']) ? trim($validated['midtrans_server_key']) : null;
        $clientKey = isset($validated['midtrans_client_key']) ? trim($validated['midtrans_client_key']) : null;
        $merchantId = isset($validated['midtrans_merchant_id']) ? trim($validated['midtrans_merchant_id']) : null;

        // Penentuan Production vs Sandbox murni dari centang checkbox pengguna
        $isProduction = $request->boolean('midtrans_is_production');

        // Verifikasi ke API Midtrans jika bukan testing dan kunci diisi
        if (!app()->environment('testing') && !empty($serverKey)) {
            $baseUrl = $isProduction ? 'https://api.midtrans.com/v2' : 'https://api.sandbox.midtrans.com/v2';
            $envLabel = $isProduction ? 'Production' : 'Sandbox';

            try {
                $response = Http::withBasicAuth($serverKey, '')
                    ->timeout(8)
                    ->get("{$baseUrl}/ping-test-connection-dummy/status");

                if ($response->status() === 401) {
                    return redirect()->route('petani.midtrans.index')
                        ->withInput()
                        ->with('error', "Kredensial Server Key ditolak oleh Midtrans ({$envLabel}). HTTP 401: Unauthorized. Silakan periksa kembali apakah Server Key sudah benar atau tertukar antara Sandbox dan Production.");
                }
            } catch (\Exception $e) {
                Log::warning('Midtrans ping check connection warning: ' . $e->getMessage());
                // Jika koneksi internet timeout, tetap izinkan simpan dengan peringatan
            }
        }

        $user->update([
            'midtrans_server_key' => $serverKey,
            'midtrans_client_key' => $clientKey,
            'midtrans_merchant_id' => $merchantId,
            'midtrans_is_production' => $isProduction,
        ]);

        // Auto-heal: Perbaiki token pesanan konsumen yang sebelumnya gagal/fallback
        $healedCount = 0;
        if (!empty($serverKey)) {
            $productIds = Produk::where('user_id', $user->id)->pluck('id');
            $pendingOrders = Pesanan::where('status', 'pending')
                ->whereHas('detailPesanan', function ($q) use ($productIds) {
                    $q->whereIn('produk_id', $productIds);
                })
                ->where(function ($q) {
                    $q->whereNull('snap_token')
                      ->orWhere('snap_token', 'like', 'FALLBACK-SNAP-%')
                      ->orWhere('snap_token', 'like', 'MOCK-SNAP-%');
                })
                ->get();

            foreach ($pendingOrders as $ord) {
                try {
                    if (app()->environment('testing')) {
                        $ord->snap_token = 'MOCK-SNAP-TOKEN-' . \Illuminate\Support\Str::random(12);
                    } else {
                        Config::$serverKey = $serverKey;
                        Config::$isProduction = $isProduction;
                        Config::$isSanitized = true;
                        Config::$is3ds = true;
                        $params = [
                            'transaction_details' => [
                                'order_id' => $ord->kode_pesanan,
                                'gross_amount' => (int) $ord->total_harga,
                            ],
                            'customer_details' => [
                                'first_name' => $ord->user?->name ?? 'Pelanggan',
                                'email' => $ord->user?->email ?? 'pelanggan@example.com',
                            ],
                        ];
                        $ord->snap_token = Snap::getSnapToken($params);
                    }
                    $ord->save();
                    $healedCount++;
                } catch (\Exception $e) {
                    Log::warning("Gagal auto-heal token pesanan {$ord->kode_pesanan}: " . $e->getMessage());
                }
            }
        }

        $envText = $isProduction ? 'Production (Live)' : 'Sandbox (Testing)';
        $msg = "Konfigurasi Midtrans akun Anda berhasil disimpan dan aktif dalam mode {$envText}!";
        if ($healedCount > 0) {
            $msg .= " Sebanyak {$healedCount} pesanan konsumen yang sebelumnya tertunda berhasil diperbarui token pembayarannya.";
        }

        return redirect()->route('petani.midtrans.index')->with('success', $msg);
    }
}
