<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\PesanOrder; // <--- WAJIB DITAMBAHKAN AGAR TIDAK ERROR DI FUNGSI SHOW
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang berisi produk milik petani ini
     * DENGAN FITUR FILTER (Produk & Tanggal).
     */
    public function index(Request $request)
    {
        $petaniId = Auth::id();

        // Query Dasar: Ambil Pesanan yang punya detail produk milik petani ini
        $query = Pesanan::whereHas('detailPesanan.produk', function($q) use ($petaniId) {
            $q->where('user_id', $petaniId);
        });

        // --- FILTER 1: Cari Nama Produk ---
        if ($request->filled('filter_produk')) {
            $keyword = $request->filter_produk;
            $query->whereHas('detailPesanan.produk', function($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%');
            });
        }

        // --- FILTER 2: Cari Tanggal ---
        if ($request->filled('filter_tanggal')) {
            $query->whereDate('created_at', $request->filter_tanggal);
        }

        // --- FILTER 3: Status ---
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Eksekusi Data
        // 'with(\'user\')' ini sudah benar untuk mengambil data nama pelanggan
        $pesananMasuk = $query->with('user') 
                              ->orderBy('created_at', 'desc')
                              ->paginate(10)
                              ->withQueryString(); 
                            
        return view('petani.pesanan.index', ['pesananMasuk' => $pesananMasuk]);
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show(string $id)
    {
        // 1. Ambil data pesanan
        $pesanan = Pesanan::where('id', $id)
                      ->with(['user', 'detailPesanan.produk']) 
                      ->firstOrFail();

        // [LOGIKA BARU] TANDAI SEBAGAI SUDAH DILIHAT (Mark as Seen)
        // Jika status masih pending DAN belum dilihat, ubah jadi dilihat.
        if ($pesanan->status == 'pending' && $pesanan->is_seen == 0) {
            $pesanan->update(['is_seen' => true]);
        }

        // 2. Ambil log pesan/chat
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
     * Update Status Pesanan
     */
   public function update(Request $request, string $id)
    {
        $petaniId = Auth::id();

        // 1. Cek Kepemilikan (Security)
        $produkIds = \App\Models\Produk::where('user_id', $petaniId)->pluck('id');
        $orderHasPetaniProduct = \App\Models\DetailPesanan::where('pesanan_id', $id)
                                              ->whereIn('produk_id', $produkIds)
                                              ->exists();
        
        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang.');
        }
        
        $pesanan = Pesanan::findOrFail($id);

        // 2. Validasi Status (Seperti sebelumnya)
        if ($request->status == 'paid') {
            return back()->with('error', 'Status "Paid" hanya boleh diubah otomatis oleh Sistem.');
        }
        if ($pesanan->status == 'paid' && $request->status == 'pending') {
            return back()->with('error', 'Pesanan sudah lunas, tidak dapat dikembalikan ke pending.');
        }

        $request->validate([
            'status' => 'required|in:shipping,done,cancelled', 
        ]);

        // === LOGIKA BARU: POTONG SALDO JIKA CANCEL ===
        // Cek kondisi: Status sebelumnya 'paid' DAN Petani minta ubah jadi 'cancelled'
        if ($pesanan->status == 'paid' && $request->status == 'cancelled') {
            
            // Ambil data petani yang sedang login
            $petani = \App\Models\User::find($petaniId);
            
            // Kurangi Saldo Petani (Refund Logic)
            // Pastikan saldo cukup, atau biarkan minus sebagai hutang
            $petani->saldo = $petani->saldo - $pesanan->seller_income;
            $petani->save();
        }
        // ============================================
        
        // 3. Simpan Perubahan Status
        $pesanan->status = $request->status;
        $pesanan->save();

        // (Opsional) Jika status cancelled, kita bisa kembalikan stok produk juga disini

        return redirect()->route('petani.pesanan.show', $pesanan->id)
                         ->with('success', 'Status diperbarui. Saldo telah disesuaikan.');
    }

    // API: Ambil Daftar Pesanan (Untuk Tab List)
    public function apiIndex(Request $request)
    {
        $user = $request->user();

        // 1. Ambil ID Produk Petani
        $productIds = Produk::where('user_id', $user->id)->pluck('id');

        if ($productIds->isEmpty()) {
            return response()->json(['success' => true, 'data' => []]);
        }

        // 2. Cari Pesanan yang memuat produk petani ini
        // Menggunakan relasi 'detailPesanan' (sesuai Model Pesanan)
        $orders = Pesanan::whereHas('detailPesanan', function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds);
        })
        ->with(['detailPesanan' => function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds)->with('produk');
        }, 'user']) // Load data pembeli
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // API: Update Status (Konfirmasi/Kirim)
    public function apiUpdateStatus(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|string' // status yang dikirim: 'confirmed', 'shipped', dll
        ]);

        // 2. Cari Pesanan Berdasarkan ID
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false, 
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        // 3. Update Status di Database
        try {
            $pesanan->status = $request->status;
            $pesanan->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah menjadi ' . $request->status,
                'data' => $pesanan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal simpan ke database: ' . $e->getMessage()
            ], 500);
        }
    }
}