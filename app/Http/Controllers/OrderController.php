<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; // Asumsi ada model Product
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        // 1. Data Dummy (Nanti ambil dari Cart/Request)
        $product = Product::find(1); // Contoh beli produk ID 1
        $harga_produk = $product->price;
        $qty = 1;
        $subtotal = $harga_produk * $qty;
        
        // 2. Hitung Komisi (5% untuk Admin)
        $admin_fee = $subtotal * 0.05; 
        $seller_income = $subtotal - $admin_fee;
        
        // 3. Simpan Order ke Database
        $order = Order::create([
            'user_id' => auth()->id(), // Pembeli
            'product_id' => $product->id, // Produk yg dibeli
            'invoice' => 'INV-' . time(),
            'total_price' => $subtotal,
            'admin_fee' => $admin_fee,
            'seller_income' => $seller_income,
            'status' => 'pending',
        ]);

        // 4. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key'); // Nanti kita set di config
        // Atau hardcode dulu untuk tes: Config::$serverKey = 'SB-Mid-server-xxxx...';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 5. Buat Parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id, // ID Order kita
                'gross_amount' => $order->total_price, // Total bayar
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        // 6. Minta Snap Token & Simpan ke DB
        $snapToken = Snap::getSnapToken($params);
        $order->snap_token = $snapToken;
        $order->save();

        // 7. Tampilkan Halaman Bayar
        return view('orders.show', compact('order', 'snapToken'));
    }
}