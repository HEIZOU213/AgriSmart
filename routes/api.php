<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- 1. IMPOR CONTROLLER (SESUAIKAN DENGAN STRUKTUR FOLDER ANDA) ---

// Controller Khusus API (Yang biasanya return JSON)
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\PetaniDashboardController; // <--- Controller Dashboard Baru
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\KeranjangController; // <--- PASTIKAN INI ADA

// Controller Umum (Hybrid: Bisa View / JSON jika ditambahkan method api*)
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController; // Untuk History Order Umum
use App\Http\Controllers\ChatController;  // Chat Umum
use App\Http\Controllers\MarketChatController; // Chat Jual Beli
use App\Http\Controllers\KontakController; // Untuk Kontak Kami

// Controller Khusus Role (Petani/Konsumen)
use App\Http\Controllers\Petani\ProdukController as PetaniProdukController;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Petani\DompetController as PetaniDompetController;
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesananController;

/*
|--------------------------------------------------------------------------
| API ROUTES AGRI SMART (SYNCHRONIZED WITH WEB)
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. PUBLIC ROUTES (TIDAK BUTUH LOGIN)
// ====================================================

// Payment Gateway Callback (Midtrans)
Route::post('midtrans-callback', [PaymentCallbackController::class, 'handle']);

// Auth (Register & Login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Halaman Depan (Public Data)
Route::get('/produk', [ProdukController::class, 'apiIndex']);      // List Produk
Route::get('/produk/{id}', [ProdukController::class, 'apiShow']);  // Detail Produk
Route::get('/edukasi', [EdukasiController::class, 'apiIndex']);    // List Edukasi
Route::get('/edukasi/{slug}', [EdukasiController::class, 'apiShow']); // Detail Edukasi

// Kontak Kami
Route::post('/kontak', [KontakController::class, 'apiStore']); // Kirim Pesan Kontak

// ====================================================
// 2. PROTECTED ROUTES (WAJIB LOGIN / BERTOKEN)
// ====================================================
Route::middleware('auth:sanctum')->group(function () {

    // --- USER INFO & LOGOUT ---
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user() // Mengambil data user yang sedang login
        ]);
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- PROFILE ---
    Route::post('/profile/update', [AuthController::class, 'updateProfile']); 
    Route::post('/profile/password', [AuthController::class, 'updatePassword']);

    // --- KERANJANG (CART) ---
    Route::get('/cart', [CartController::class, 'apiIndex']); 
    Route::post('/cart/add', [CartController::class, 'apiStore']); 
    Route::patch('/cart/update/{id}', [CartController::class, 'apiUpdate']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'apiDestroy']);

    // --- CHECKOUT & ORDER HISTORY (UMUM) ---
    Route::post('/checkout', [CheckoutController::class, 'apiProcess']); // Proses Pesanan
    Route::get('/orders', [OrderController::class, 'index']); // List Semua Order User Tersebut
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Detail Order

    // --- CHAT SYSTEM (MARKET & UMUM) ---
    // Chat Umum
    Route::get('/chat', [ChatController::class, 'apiIndex']); 
    Route::get('/chat/{id}', [ChatController::class, 'apiGetMessages']); 
    Route::post('/chat/send', [ChatController::class, 'apiSendMessage']); 
    
    // Market Chat (Sesuai Web)
    Route::get('/market-chat/list', [MarketChatController::class, 'getChatList']);
    Route::get('/market-chat/{receiver_id}', [MarketChatController::class, 'getMessages']);
    Route::post('/market-chat/send', [MarketChatController::class, 'sendMessage']);

    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::get('/keranjang/count', [KeranjangController::class, 'count']);
    Route::get('/notifikasi/count', [NotifikasiController::class, 'countUnread']);

    // ====================================================
    // 3. ROLE: PETANI ROUTES
    // ====================================================
    Route::middleware('role:petani')->group(function () {
        
        // Dashboard Petani (Menggunakan Controller Baru yang kita buat)
        Route::get('/petani/dashboard', [PetaniDashboardController::class, 'index']);

        // Manajemen Produk (CRUD)
        Route::get('/petani/produk', [PetaniProdukController::class, 'apiIndex']);
        Route::post('/petani/produk/store', [PetaniProdukController::class, 'apiStore']);
        Route::post('/petani/produk/{id}', [PetaniProdukController::class, 'apiUpdate']); // Pakai POST untuk update file di Flutter
        Route::delete('/petani/produk/{id}', [PetaniProdukController::class, 'apiDestroy']);

        // Manajemen Pesanan Masuk
        Route::get('/petani/pesanan', [PetaniPesananController::class, 'apiIndex']);
        Route::post('/petani/pesanan/{id}/update-status', [PetaniPesananController::class, 'apiUpdateStatus']);

        // Dompet Petani (Optional: Jika di Flutter mau ditampilkan)
        // Route::get('/petani/dompet', [PetaniDompetController::class, 'apiIndex']);
    });

    // ====================================================
    // 4. ROLE: KONSUMEN ROUTES
    // ====================================================
    Route::middleware('role:konsumen')->group(function () {
        
        // Pesanan Konsumen (History & Tracking)
        Route::get('/konsumen/pesanan', [KonsumenPesananController::class, 'apiIndex']);
        
        // Cancel Pesanan
        Route::put('/konsumen/pesanan/{id}/cancel', [KonsumenPesananController::class, 'apiCancel']);
    });

});