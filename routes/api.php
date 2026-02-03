<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- 1. IMPOR CONTROLLER ---

// Controller Khusus API
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\PetaniDashboardController; 
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\KeranjangController;

// Controller Umum (Hybrid)
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\ChatController;       // Chat Umum
use App\Http\Controllers\MarketChatController; // Chat Jual Beli
use App\Http\Controllers\KontakController;     // Untuk Kontak Kami

// Controller Khusus Role (Petani/Konsumen)
use App\Http\Controllers\Petani\ProdukController as PetaniProdukController;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Petani\DompetController as PetaniDompetController;
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesananController;

// --- IMPORT CONTROLLER IOT ---
use App\Http\Controllers\IotController;

// --- IMPORT MIDDLEWARE ---
use App\Http\Middleware\UserActivity; // <--- TAMBAHKAN INI

/*
|--------------------------------------------------------------------------
| API ROUTES AGRI SMART (FULL IOT & WEB SYNC VERSION)
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. PUBLIC ROUTES (TIDAK BUTUH LOGIN)
// ====================================================

Route::post('/login/google', [App\Http\Controllers\Api\AuthController::class, 'loginByGoogle']);

// Payment Gateway Callback (Midtrans)
Route::post('midtrans-callback', [App\Http\Controllers\CheckoutController::class, 'callback']);

// Auth (Register & Login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- RUTE IOT UNTUK ESP32 (WAJIB PUBLIC) ---
Route::post('/iot/receive', [IotController::class, 'receiveData']);

// Halaman Depan (Public Data)
Route::get('/produk', [ProdukController::class, 'apiIndex']);       // List Produk
Route::get('/produk/{id}', [ProdukController::class, 'apiShow']);   // Detail Produk
Route::get('/edukasi', [EdukasiController::class, 'apiIndex']);     // List Edukasi
Route::get('/edukasi/{slug}', [EdukasiController::class, 'apiShow']); // Detail Edukasi

// Kontak Kami
Route::post('/kontak', [KontakController::class, 'apiStore']); // Kirim Pesan Kontak


// ====================================================
// 2. PROTECTED ROUTES (WAJIB LOGIN / BERTOKEN)
// ====================================================
// [PERBAIKAN] Tambahkan UserActivity di sini agar jalan setelah login divalidasi
Route::middleware(['auth:sanctum', UserActivity::class])->group(function () {

    // --- USER INFO & LOGOUT ---
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user() 
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

    // --- CHECKOUT & ORDER HISTORY ---
    Route::post('/checkout', [CheckoutController::class, 'apiProcess']); // Proses Pesanan
    Route::get('/orders', [OrderController::class, 'index']); // List Semua Order User Tersebut
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Detail Order

    // --- CHAT SYSTEM (MARKET & UMUM) ---
    // Chat Umum
    Route::get('/chat', [ChatController::class, 'apiIndex']); 
    Route::get('/chat/{id}', [ChatController::class, 'apiGetMessages']); 
    Route::post('/chat/send', [ChatController::class, 'apiSendMessage']); 
    
    // Market Chat (Sesuai Web - INI PENTING UNTUK MOBILE APP)
    // Mobile App akan akses endpoint ini untuk update Last Seen & Chat
    Route::get('/market-chat/list', [MarketChatController::class, 'getChatList']);
    Route::get('/market-chat/{receiver_id}', [MarketChatController::class, 'getMessages']);
    Route::post('/market-chat/send', [MarketChatController::class, 'sendMessage']);

    // --- NOTIFIKASI & COUNTING ---
    Route::get('/notifikasi', [NotifikasiController::class, 'index']);
    Route::get('/keranjang/count', [KeranjangController::class, 'count']);
    Route::get('/notifikasi/count', [NotifikasiController::class, 'countUnread']);

    // ====================================================
    // 3. ROLE: PETANI ROUTES
    // ====================================================
    Route::middleware('role:petani')->group(function () {
        
        // Dashboard Petani
        Route::get('/petani/dashboard', [PetaniDashboardController::class, 'index']);
        
        // Manajemen Produk Petani
        Route::get('/petani/produk', [PetaniProdukController::class, 'apiIndex']);
        Route::post('/petani/produk/store', [PetaniProdukController::class, 'apiStore']);
        Route::post('/petani/produk/{id}', [PetaniProdukController::class, 'apiUpdate']); 
        Route::delete('/petani/produk/{id}', [PetaniProdukController::class, 'apiDestroy']);
        
        // Pesanan Masuk
        Route::get('/petani/pesanan', [PetaniPesananController::class, 'apiIndex']);
        Route::post('/petani/pesanan/{id}/update-status', [PetaniPesananController::class, 'apiUpdateStatus']);

        // --- MANAJEMEN ALAT IOT (PETANI) ---
        Route::get('/petani/iot', [IotController::class, 'index']);        // List semua alat
        Route::post('/petani/iot/claim', [IotController::class, 'claimDevice']); // Klaim alat baru
        Route::post('/petani/iot/toggle/{id}', [IotController::class, 'togglePump']); // On/Off Pompa
        Route::post('/petani/iot/auto/{id}', [IotController::class, 'setAuto']); // Set ke Auto
<<<<<<< HEAD
        Route::get('/iot/data/{serial_number}', [IotController::class, 'getLatestData']);

        // Dompet Petani (Optional)
        // Route::get('/petani/dompet', [PetaniDompetController::class, 'apiIndex']);
=======
>>>>>>> 6f17b916f8252c1fcb2eb53b4e2d51bb8c0d3d40
    });

    // ====================================================
    // 4. ROLE: KONSUMEN ROUTES
    // ====================================================
    Route::middleware('role:konsumen')->group(function () {
        
        // Route Cancel Order untuk Flutter
        Route::post('/orders/{id}/cancel', [KonsumenPesananController::class, 'apiCancel']);

        // Backup Route
        Route::post('/pesanan/{id}/cancel', [KonsumenPesananController::class, 'apiCancel']);
    });

});