<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    /**
     * Tampilkan halaman Scanner QR Code Pekebun.
     */
    public function index()
    {
        return view('petani.scan.index');
    }

    /**
     * Verifikasi kode dari hasil scan kamera atau input manual.
     */
    public function verify(Request $request)
    {
        $rawCode = trim($request->input('code', ''));

        if (empty($rawCode)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode QR kosong.'], 422);
            }
            return back()->with('error', 'Kode QR tidak boleh kosong.');
        }

        // Jika scanner menangkap URL lengkap (e.g., http://.../konsumen/pesanan/5/kwitansi)
        $orderId = null;
        if (preg_match('#/konsumen/pesanan/(\d+)#', $rawCode, $matches)) {
            $orderId = (int)$matches[1];
        }

        $query = Pesanan::with(['user', 'detailPesanan.produk']);

        if ($orderId) {
            $pesanan = $query->find($orderId);
        } else {
            $pesanan = $query->where('kode_pesanan', $rawCode)
                ->orWhere('kwitansi_nomor', $rawCode)
                ->orWhere('kwitansi_qr_payload', $rawCode)
                ->first();
        }

        if (!$pesanan) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Pesanan dengan kode '{$rawCode}' tidak ditemukan."
                ], 404);
            }
            return back()->with('error', "Pesanan tidak ditemukan.");
        }

        // Validasi bahwa pesanan ini benar milik produk pekebun yang sedang login
        $pekebunId = Auth::id();
        $productIds = Produk::where('user_id', $pekebunId)->pluck('id');
        $isPekebunOrder = DetailPesanan::where('pesanan_id', $pesanan->id)
            ->whereIn('produk_id', $productIds)
            ->exists();

        if (!$isPekebunOrder) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan ini bukan ditujukan untuk produk Anda.'
                ], 403);
            }
            return back()->with('error', 'Akses ditolak. Pesanan bukan produk Anda.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $pesanan->id,
                    'kode_pesanan' => $pesanan->kode_pesanan,
                    'kwitansi_nomor' => $pesanan->kwitansi_nomor,
                    'pembeli' => $pesanan->user?->name ?? 'Konsumen',
                    'tipe_pesanan' => $pesanan->tipe_pesanan,
                    'status' => $pesanan->status,
                    'is_booking' => $pesanan->isBookingDurian(),
                    'berat_aktual_kg' => $pesanan->berat_aktual_kg,
                    'harga_per_kg' => $pesanan->harga_per_kg,
                    'dp_amount' => $pesanan->dp_amount,
                    'total_setelah_timbang' => $pesanan->total_setelah_timbang,
                    'sisa_pelunasan' => $pesanan->sisa_pelunasan,
                    'redirect_url' => route('petani.pesanan.show', $pesanan->id),
                ]
            ]);
        }

        return redirect()->route('petani.pesanan.show', $pesanan->id)
            ->with('success', "Data QR Valid: Pesanan #{$pesanan->kode_pesanan} berhasil diverifikasi!");
    }
}
