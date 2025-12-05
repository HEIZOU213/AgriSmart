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
        // Ambil data pesanan beserta user dan produknya
        $pesanan = Pesanan::where('id', $id)
                      ->with(['user', 'detailPesanan.produk']) 
                      ->firstOrFail();

        // Ambil log pesan/chat (Pastikan Model PesanOrder sudah di-use di atas)
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

        // Cek apakah pesanan ini benar mengandung produk milik petani yang login
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');
        $orderHasPetaniProduct = DetailPesanan::where('pesanan_id', $id)
                                              ->whereIn('produk_id', $produkIds)
                                              ->exists();
        
        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang. Anda tidak memiliki produk di pesanan ini.');
        }
        
        $request->validate([
            'status' => 'required|in:paid,shipping,done,cancelled',
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('petani.pesanan.show', $pesanan->id)
                         ->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status . '.');
    }

    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
    public function destroy(string $id) { abort(404); }
}