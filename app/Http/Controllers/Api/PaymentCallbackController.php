<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User; // Model User untuk update saldo
use Midtrans\Config;

class PaymentCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        // 1. Verifikasi Signature Key (Keamanan)
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        if ($hashed == $request->signature_key) {
            
            // 2. Cek Status Transaksi
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                $order = Order::find($request->order_id);
                
                // Pastikan order belum diproses sebelumnya
                if($order->status == 'pending'){
                    
                    // Update status order
                    $order->update(['status' => 'success']);
                    
                    // --- BAGI HASIL DI SINI ---
                    // Cari petani pemilik produk (Asumsi ada relasi di model Product)
                    // $petani_id = $order->product->user_id; 
                    
                    // Contoh sederhana manual query:
                    $product = \App\Models\Product::find($order->product_id);
                    $petani = User::find($product->user_id);
                    
                    // Tambah Saldo Petani
                    $petani->balance += $order->seller_income;
                    $petani->save();
                    // --------------------------
                }
            }
        }
    }
}