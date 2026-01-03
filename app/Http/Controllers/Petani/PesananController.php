<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\PesanOrder;
use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB untuk transaksi

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan (Versi WEB)
     */
    public function index(Request $request)
    {
        $petaniId = Auth::id();

        // Query Dasar
        $query = Pesanan::whereHas('detailPesanan.produk', function($q) use ($petaniId) {
            $q->where('user_id', $petaniId);
        });

        // Filter
        if ($request->filled('filter_produk')) {
            $keyword = $request->filter_produk;
            $query->whereHas('detailPesanan.produk', function($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%');
            });
        }
        if ($request->filled('filter_tanggal')) {
            $query->whereDate('created_at', $request->filter_tanggal);
        }
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        $pesananMasuk = $query->with('user')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString();
                            
        return view('petani.pesanan.index', ['pesananMasuk' => $pesananMasuk]);
    }

    /**
     * Detail Pesanan (Versi WEB)
     */
    public function show(string $id)
    {
        $pesanan = Pesanan::where('id', $id)
                          ->with(['user', 'detailPesanan.produk'])
                          ->firstOrFail();

        // Tandai sudah dilihat (Pastikan kolom is_seen ada di DB)
        if ($pesanan->status == 'pending' && $pesanan->is_seen == 0) {
            $pesanan->update(['is_seen' => true]);
        }

        // Ambil log pesan
        $pesanLog = PesanOrder::where('pesanan_id', $id)
                              ->with('user')
                              ->orderBy('created_at', 'asc')
                              ->get();

        return view('petani.pesanan.show', [
            'pesanan' => $pesanan,
            'pesanLog' => $pesanLog
        ]);
    }

    /**
     * Update Status (Versi WEB)
     */
    public function update(Request $request, string $id)
    {
        $petaniId = Auth::id();

        // 1. Cek Kepemilikan (Security)
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');
        $orderHasPetaniProduct = DetailPesanan::where('pesanan_id', $id)
                                              ->whereIn('produk_id', $produkIds)
                                              ->exists();
        
        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang.');
        }
        
        $pesanan = Pesanan::findOrFail($id);

        // 2. Validasi Status
        if ($request->status == 'paid') {
            return back()->with('error', 'Status "Paid" hanya boleh diubah otomatis oleh Sistem.');
        }
        if ($pesanan->status == 'paid' && $request->status == 'pending') {
            return back()->with('error', 'Pesanan sudah lunas, tidak dapat dikembalikan ke pending.');
        }

        $request->validate([
            'status' => 'required|in:shipping,done,cancelled', 
        ]);

        // 3. LOGIKA POTONG SALDO (Refund)
        if ($pesanan->status == 'paid' && $request->status == 'cancelled') {
            $petani = User::find($petaniId);
            $petani->saldo = $petani->saldo - $pesanan->seller_income;
            $petani->save();
        }
        
        // 4. LOGIKA KEMBALIKAN STOK (Restock)
        if ($request->status == 'cancelled' && $pesanan->status != 'cancelled') {
             foreach ($pesanan->detailPesanan as $detail) {
                $produk = $detail->produk;
                if ($produk && $produk->user_id == $petaniId) {
                    $produk->stok = $produk->stok + $detail->jumlah;
                    $produk->save();
                }
            }
        }

        // 5. Simpan Perubahan Status
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('petani.pesanan.show', $pesanan->id)
                         ->with('success', 'Status diperbarui.');
    }

    // ----------------------------------------------------------------------
    // API (UNTUK APLIKASI FLUTTER)
    // ----------------------------------------------------------------------

    // API: Ambil Daftar Pesanan
    public function apiIndex(Request $request)
    {
        $user = $request->user();
        $productIds = Produk::where('user_id', $user->id)->pluck('id');

        if ($productIds->isEmpty()) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $orders = Pesanan::whereHas('detailPesanan', function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds);
        })
        ->with(['detailPesanan' => function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds)->with('produk');
        }, 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // API: Update Status (DIPERBAIKI DENGAN NOTIFIKASI OTOMATIS)
    public function apiUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        return DB::transaction(function () use ($request, $id) {
            $user = $request->user();
            
            // Load detail pesanan, produk, DAN user pembeli
            $pesanan = Pesanan::with(['detailPesanan.produk', 'user'])->find($id);

            if (!$pesanan) {
                return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan'], 404);
            }

            $oldStatus = $pesanan->status;
            $newStatus = $request->status;
            $pembeliId = $pesanan->user_id; // AMBIL ID PEMBELI SECARA OTOMATIS

            // 1. LOGIKA RESTOCK (Jika batal, kembalikan stok)
            if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
                foreach ($pesanan->detailPesanan as $detail) {
                    $produk = $detail->produk;
                    if ($produk && $produk->user_id == $user->id) {
                        $produk->stok = $produk->stok + $detail->jumlah;
                        $produk->save();
                    }
                }
            }

            // 2. LOGIKA REFUND (Potong Saldo Petani jika sudah lunas tapi dibatalkan)
            if ($oldStatus == 'paid' && $newStatus == 'cancelled') {
                $pendapatan = $pesanan->seller_income ?? 0;
                
                if ($pendapatan > 0) {
                    $petani = User::find($user->id);
                    $petani->saldo = $petani->saldo - $pendapatan;
                    $petani->save();
                }
            }

            // 3. --- [BARU] LOGIKA KIRIM NOTIFIKASI OTOMATIS ---
            $judul = "Update Pesanan #" . ($pesanan->kode_pesanan ?? $pesanan->id);
            $pesan = "";
            $type = "info";

            if ($newStatus == 'paid') {
                $pesan = "Pesanan Anda telah DITERIMA oleh petani dan sedang diproses.";
                $type = "success";
            } elseif ($newStatus == 'shipping') {
                $pesan = "Pesanan Anda sedang DALAM PENGIRIMAN menuju alamat Anda.";
                $type = "info";
            } elseif ($newStatus == 'cancelled') {
                $pesan = "Mohon maaf, pesanan Anda DIBATALKAN oleh petani. Stok akan dikembalikan.";
                $type = "danger";
            } elseif ($newStatus == 'done') {
                $pesan = "Pesanan selesai. Terima kasih telah berbelanja!";
                $type = "success";
            }

            // Buat Notifikasi di Database (Hanya jika ada pesan status)
            if ($pesan != "") {
                Notifikasi::create([
                    'user_id' => $pembeliId, // Ini akan otomatis mengirim ke pembeli yang benar
                    'judul'   => $judul,
                    'pesan'   => $pesan,
                    'type'    => $type,
                    'is_read' => false
                ]);
            }
            // ------------------------------------------------

            $pesanan->status = $newStatus;
            $pesanan->save();

            return response()->json([
                'success' => true, 
                'message' => 'Status berhasil diubah & Notifikasi terkirim', 
                'data' => $pesanan
            ]);
        });
    }
}