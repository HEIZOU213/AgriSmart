<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang; // <-- Gunakan Model Baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        // Ambil keranjang dari DATABASE milik user yang login
        $userId = Auth::id();
        
        // Ambil data keranjang beserta detail produknya
        $cartItems = Keranjang::where('user_id', $userId)->with('produk')->get();

        // Kita format agar strukturnya sama seperti view cart kita sebelumnya
        $cart = [];
        foreach($cartItems as $item) {
            $cart[$item->produk_id] = [
                "nama" => $item->produk->nama_produk,
                "jumlah" => $item->jumlah,
                "harga" => $item->produk->harga,
                "foto" => $item->produk->foto_produk
            ];
        }
        
        return view('cart.index', ['cart' => $cart]);
    }

    public function store(Request $request, $id)
    {
        // Cek Keamanan Role
        if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'petani')) {
            return redirect()->back()->with('error', 'Hanya akun Konsumen yang boleh berbelanja.');
        }

        $produk = Produk::findOrFail($id);
        $userId = Auth::id();
        $jumlahDiminta = $request->input('jumlah', 1);

        // Validasi Stok
        if ($jumlahDiminta > $produk->stok) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }

        // Cek apakah produk sudah ada di keranjang database user ini
        $itemKeranjang = Keranjang::where('user_id', $userId)
                                  ->where('produk_id', $id)
                                  ->first();

        if ($itemKeranjang) {
            // Jika ada, update jumlahnya
            $itemKeranjang->jumlah += $jumlahDiminta;
            
            // Cek stok lagi setelah ditambah
            if ($itemKeranjang->jumlah > $produk->stok) {
                return redirect()->back()->with('error', 'Total jumlah melebihi stok yang tersedia.');
            }
            
            $itemKeranjang->save();
        } else {
            // Jika belum ada, buat baru di database
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $id,
                'jumlah' => $jumlahDiminta
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil disimpan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $produk = Produk::findOrFail($id);

        if ($request->jumlah > $produk->stok) {
             return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Update di Database
        $item = Keranjang::where('user_id', $userId)->where('produk_id', $id)->first();
        
        if ($item) {
            $item->jumlah = $request->jumlah;
            $item->save();
            return redirect()->back()->with('success', 'Jumlah diperbarui.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function destroy($id)
    {
        $userId = Auth::id();

        // Hapus dari Database
        Keranjang::where('user_id', $userId)->where('produk_id', $id)->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    // =================================================================
    // BAGIAN 2: KHUSUS UNTUK APLIKASI FLUTTER (API / JSON)
    // =================================================================

    // 1. API: Ambil Daftar Keranjang
    public function apiIndex()
    {
        // Ganti Cart:: menjadi Keranjang::
        $carts = Keranjang::with('produk')->where('user_id', Auth::id())->get();

        return response()->json([
            'success' => true,
            'data' => $carts
        ]);
    }

    // 2. API: Tambah ke Keranjang
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:produk,id',
            'qty'        => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Ganti Cart:: menjadi Keranjang::
        $existingCart = Keranjang::where('user_id', Auth::id())
                            ->where('produk_id', $request->product_id)
                            ->first();

        if ($existingCart) {
            $existingCart->jumlah += $request->qty;
            $existingCart->save();
        } else {
            // Ganti Cart:: menjadi Keranjang::
            Keranjang::create([
                'user_id'   => Auth::id(),
                'produk_id' => $request->product_id,
                'jumlah'    => $request->qty
            ]);
        }

        return response()->json([
            'success' => true, 
            'message' => 'Produk berhasil masuk keranjang'
        ]);
    }

    // 3. API: Hapus Item
    public function apiDestroy($id)
    {
        // Ganti Cart:: menjadi Keranjang::
        $cart = Keranjang::where('user_id', Auth::id())->where('id', $id)->first();
        
        if ($cart) {
            $cart->delete();
            return response()->json(['success' => true, 'message' => 'Item dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
    }
}