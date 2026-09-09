<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan (YANG BELUM DIARSIP).
     */
    public function index()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                        ->where('konsumen_arsip', false) // <-- [FIX] Hanya tampilkan yang belum diarsip
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
                            
        return view('konsumen.pesanan.index', ['pesanan' => $pesanan]);
    }

    /* (Metode create, store, edit, update tetap abort(404)) */
    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
    public function update(Request $request, string $id) { abort(404); }


    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
                        ->with(['detailPesanan.produk']) 
                        ->findOrFail($id);
                        
        return view('konsumen.pesanan.show', [
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * [FIX] Meng-ARSIPKAN pesanan (bukan menghapus).
     */
    public function destroy(string $id)
    {
        // 1. Ambil pesanan, pastikan milik user yang login
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        // 2. Ubah status 'konsumen_arsip' menjadi true
        $pesanan->konsumen_arsip = true;
        $pesanan->save();

        return redirect()->route('konsumen.pesanan.index')
                         ->with('success', 'Riwayat pesanan ' . $pesanan->kode_pesanan . ' berhasil diarsipkan.');
    }

    /**
     * Membatalkan pesanan (Versi Web untuk Konsumen).
     */
    public function cancel(string $id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena status bukan pending.');
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Kembalikan stok produk
            foreach ($pesanan->detailPesanan as $detail) {
                if ($detail->produk) {
                    $detail->produk->increment('stok', $detail->jumlah);
                }
            }

            $pesanan->status = 'cancelled';
            $pesanan->save();

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('konsumen.pesanan.index')
                             ->with('success', 'Pesanan #' . $pesanan->kode_pesanan . ' berhasil dibatalkan.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
        }
    }

    /**
     * Konfirmasi Pesanan Selesai / Diterima oleh Konsumen.
     */
    public function selesai(string $id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status !== 'shipping') {
            return redirect()->back()->with('error', 'Pesanan hanya dapat diselesaikan saat dalam status pengiriman.');
        }

        $pesanan->status = 'done';
        $pesanan->save();

        // Notifikasi ke pekebun durian
        try {
            $sellerId = optional($pesanan->detailPesanan->first()?->produk)->user_id;
            if ($sellerId) {
                \App\Models\Notifikasi::create([
                    'user_id' => $sellerId,
                    'judul'   => 'Pesanan #' . ($pesanan->kode_pesanan ?? $pesanan->id) . ' Diterima',
                    'pesan'   => 'Pembeli telah mengonfirmasi bahwa produk telah sampai dan pesanan selesai.',
                    'type'    => 'success',
                    'is_read' => false
                ]);
            }
        } catch (\Exception $e) {}

        return redirect()->back()->with('success', 'Pesanan #' . $pesanan->kode_pesanan . ' telah diselesaikan. Terima kasih!');
    }


    // ================= API SECTION (Mobile) =================

    /**
     * API: List semua pesanan user yang login
     */
    public function apiIndex()
    {
        $orders = Pesanan::where('user_id', Auth::id())
                    ->with('detailPesanan.produk')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * API: Detail pesanan berdasarkan ID
     */
    public function apiShow($id)
    {
        $order = Pesanan::where('user_id', Auth::id())
                    ->with('detailPesanan.produk')
                    ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function apiCancel(Request $request, $id)
    {
        // 1. Cari Pesanan berdasarkan ID
        $pesanan = \App\Models\Pesanan::find($id);

        // 2. Cek apakah pesanan ada?
        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        // 3. Cek kepemilikan (Opsional: pastikan user yg login yg punya pesanan)
        if ($pesanan->user_id != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ], 403);
        }

        // 4. Cek Status (Hanya 'pending' yang boleh batal)
        if ($pesanan->status != 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dapat dibatalkan karena status bukan pending'
            ], 400);
        }

        // 5. Lakukan Pembatalan dalam transaksi aman
        \Illuminate\Support\Facades\DB::transaction(function () use ($pesanan) {
            foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                if ($produk) {
                    $produk->increment('stok', $detail->jumlah);
                }
            }

            $pesanan->status = 'cancelled';
            $pesanan->save();
        });

        // 6. Return JSON Sukses (PENTING: Status Code 200)
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibatalkan',
            'data' => $pesanan
        ], 200);
    }

    public function apiSelesai(Request $request, $id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        if ($pesanan->status !== 'shipping') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan hanya dapat diselesaikan saat dalam status pengiriman'
            ], 400);
        }

        $pesanan->status = 'done';
        $pesanan->save();

        try {
            $sellerId = optional($pesanan->detailPesanan->first()?->produk)->user_id;
            if ($sellerId) {
                \App\Models\Notifikasi::create([
                    'user_id' => $sellerId,
                    'judul'   => 'Pesanan #' . ($pesanan->kode_pesanan ?? $pesanan->id) . ' Diterima',
                    'pesan'   => 'Pembeli telah mengonfirmasi bahwa produk telah sampai dan pesanan selesai.',
                    'type'    => 'success',
                    'is_read' => false
                ]);
            }
        } catch (\Exception $e) {}

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diselesaikan',
            'data'    => $pesanan
        ], 200);
    }

    /**
     * Tampilkan E-Kwitansi resmi dengan QR Code.
     */
    public function kwitansi(string $id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.produk.user'])->findOrFail($id);

        $user = Auth::user();
        $isOwner = $user && $pesanan->user_id === $user->id;
        $isSeller = false;
        if ($user) {
            $sellerIds = $pesanan->detailPesanan->map(fn($d) => $d->produk?->user_id)->filter()->all();
            $isSeller = in_array($user->id, $sellerIds);
        }
        $isAdmin = $user && $user->role === 'admin';

        if (!$isOwner && !$isSeller && !$isAdmin) {
            abort(403, 'Akses Kwitansi Ditolak.');
        }

        return view('konsumen.pesanan.kwitansi', compact('pesanan'));
    }

    /**
     * Proses bayar pelunasan via Midtrans Snap.
     */
    public function bayarPelunasan(Request $request, string $id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.produk.user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($pesanan->status !== 'menunggu_pelunasan' || ($pesanan->sisa_pelunasan ?? 0) <= 0) {
            return back()->with('error', 'Pesanan ini tidak memerlukan pelunasan.');
        }

        $seller = $pesanan->getPekebun();
        if (!$pesanan->pelunasan_snap_token) {
            if (app()->environment('testing') || empty($seller?->getMidtransServerKey())) {
                $pesanan->pelunasan_snap_token = 'MOCK-PELUNASAN-SNAP-' . \Illuminate\Support\Str::random(12);
            } else {
                try {
                    \Midtrans\Config::$serverKey = $seller->getMidtransServerKey();
                    \Midtrans\Config::$isProduction = $seller->isMidtransProduction();
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;

                    $params = [
                        'transaction_details' => [
                            'order_id' => 'PELUNASAN-' . $pesanan->kode_pesanan,
                            'gross_amount' => (int) $pesanan->sisa_pelunasan,
                        ],
                        'customer_details' => [
                            'first_name' => Auth::user()->name,
                            'email' => Auth::user()->email,
                        ],
                    ];
                    $pesanan->pelunasan_snap_token = \Midtrans\Snap::getSnapToken($params);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning('Pelunasan snap generation fallback: ' . $e->getMessage());
                    $pesanan->pelunasan_snap_token = 'FALLBACK-PELUNASAN-SNAP-' . \Illuminate\Support\Str::random(12);
                }
            }
            $pesanan->save();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'snap_token' => $pesanan->pelunasan_snap_token,
                'sisa_pelunasan' => $pesanan->sisa_pelunasan,
            ]);
        }

        return redirect()->route('konsumen.pesanan.kwitansi', $pesanan->id);
    }
}

