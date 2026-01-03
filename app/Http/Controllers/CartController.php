<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // =================================================================
    // BAGIAN 1: WEB VIEW (Browser Desktop/Mobile)
    // =================================================================

    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil data dengan Eager Loading 'produk.user' agar hemat query database
        // Kita butuh data 'user' (penjual) dari produk untuk grouping
        $cartItems = Keranjang::where('user_id', $userId)
            ->with(['produk.user'])
            ->get();

        // 2. LOGIKA GROUPING (Dipindahkan dari Blade ke sini)
        // Kita ubah format data agar siap pakai di View
        $groupedCart = $cartItems->map(function ($item) {
            $produk = $item->produk;
            $penjual = $produk->user ? $produk->user->name : 'AgriSmart Seller';

            return (object) [
                'id' => $produk->id, // ID Produk
                'cart_id' => $item->id,   // ID Item Keranjang
                'nama_penjual' => $penjual,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'jumlah' => $item->jumlah,
                'foto' => $produk->foto_produk,
                'satuan' => $produk->satuan ?? 'kg',
                'stok' => $produk->stok
            ];
        })->groupBy('nama_penjual');

        // Kirim $groupedCart ke View, dan $cartItems untuk menghitung total item di badge
        return view('cart.index', [
            'groupedCart' => $groupedCart,
            'cart' => $cartItems // Untuk hitung count($cart) di view
        ]);
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

        // Validasi Stok Awal
        if ($jumlahDiminta > $produk->stok) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }

        $itemKeranjang = Keranjang::where('user_id', $userId)
            ->where('produk_id', $id)
            ->first();

        if ($itemKeranjang) {
            // Cek apakah penambahan ini akan melebihi stok total
            if (($itemKeranjang->jumlah + $jumlahDiminta) > $produk->stok) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menambah jumlah tersebut.');
            }

            $itemKeranjang->jumlah += $jumlahDiminta;
            $itemKeranjang->save();
        } else {
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $id,
                'jumlah' => $jumlahDiminta
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil disimpan ke keranjang');
    }

    // FUNGSI BARU: Update via AJAX (Tanpa Reload Halaman)
    public function updateQuantityAjax(Request $request, $id)
    {
        $userId = Auth::id();
        $item = Keranjang::where('user_id', $userId)->where('produk_id', $id)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        $produk = $item->produk;
        $qtyBaru = $request->quantity;

        // Validasi Stok
        if ($qtyBaru > $produk->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi (Max: ' . $produk->stok . ')'
            ], 400);
        }

        if ($qtyBaru < 1) {
            return response()->json(['success' => false, 'message' => 'Minimal pembelian 1'], 400);
        }

        // Simpan Perubahan
        $item->jumlah = $qtyBaru;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Jumlah diperbarui'
        ]);
    }

    // Fungsi Destroy Biasa (Tombol Hapus)
    public function destroy($id)
    {
        $userId = Auth::id();
        Keranjang::where('user_id', $userId)->where('produk_id', $id)->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    // =================================================================
    // BAGIAN 2: KHUSUS UNTUK APLIKASI FLUTTER (API / JSON)
    // =================================================================

    public function apiIndex()
    {
        $carts = Keranjang::with('produk')->where('user_id', Auth::id())->get();
        return response()->json(['success' => true, 'data' => $carts]);
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:produk,id',
            'qty' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $existingCart = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->jumlah += $request->qty;
            $existingCart->save();
        } else {
            Keranjang::create([
                'user_id' => Auth::id(),
                'produk_id' => $request->product_id,
                'jumlah' => $request->qty
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Produk masuk keranjang']);
    }

    public function apiDestroy($id)
    {
        $cart = Keranjang::where('user_id', Auth::id())->where('id', $id)->first();
        if ($cart) {
            $cart->delete();
            return response()->json(['success' => true, 'message' => 'Item dihapus']);
        }
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
    }
}