<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang berisi produk milik petani ini.
     */
    public function index()
    {
        $petaniId = Auth::id();

        // 1. Dapatkan ID Produk yang dimiliki oleh petani yang login
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');

        // 2. Dapatkan ID Pesanan (Pesanan Masuk) yang mengandung produk tersebut
        $pesananIds = DetailPesanan::whereIn('produk_id', $produkIds)
                                    ->pluck('pesanan_id')
                                    ->unique();

        // 3. Ambil data Pesanan utama
        $pesananMasuk = Pesanan::whereIn('id', $pesananIds)
                                ->with('user') // Ambil data konsumen
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
                            
        return view('petani.pesanan.index', ['pesananMasuk' => $pesananMasuk]);
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    // Di dalam Petani/PesananController.php

public function show(string $id)
{
    // ... (Kode keamanan Anda tetap di sini) ...

    $pesanan = Pesanan::where('id', $id)
                      ->with(['user', 'detailPesanan.produk']) 
                      ->firstOrFail();

    // [KODE BARU]
    $pesanLog = \App\Models\PesanOrder::where('pesanan_id', $id)
                                ->with('user') // Ambil data pengirim
                                ->orderBy('created_at', 'asc')
                                ->get();

    return view('petani.pesanan.show', [
        'pesanan' => $pesanan,
        'pesanLog' => $pesanLog // <-- Kirim pesan ke view
    ]);
}

    /**
     * Memperbarui status pesanan.
     */
    public function update(Request $request, string $id)
    {
        $petaniId = Auth::id();

        // 1. Cek Keamanan (sama seperti show)
        $produkIds = Produk::where('user_id', $petaniId)->pluck('id');
        $orderHasPetaniProduct = DetailPesanan::where('pesanan_id', $id)
                                              ->whereIn('produk_id', $produkIds)
                                              ->exists();
        
        if (!$orderHasPetaniProduct) {
            abort(403, 'Akses Dilarang.');
        }
        
        // 2. Validasi status baru
        $request->validate([
            'status' => 'required|in:paid,shipping,done,cancelled',
        ]);
        
        // 3. Update status pesanan
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('petani.pesanan.show', $pesanan->id)
                         ->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status . '.');
    }
    
    // Metode 'create', 'store', 'edit', 'destroy' tidak digunakan oleh Petani
    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(string $id) { abort(404); }
    public function destroy(string $id) { abort(404); }
}