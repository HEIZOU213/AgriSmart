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
<<<<<<< HEAD
use App\Http\Controllers\OrderController; 
=======
use App\Http\Controllers\OrderController; // Untuk History Order Umum
use App\Http\Controllers\ChatController;  // Chat Umum
use App\Http\Controllers\MarketChatController; // Chat Jual Beli
use App\Http\Controllers\KontakController; // Untuk Kontak Kami
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec

// Controller Khusus Role (Petani/Konsumen)
use App\Http\Controllers\Petani\ProdukController as PetaniProdukController;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Petani\DompetController as PetaniDompetController;
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesananController;

// --- IMPORT CONTROLLER IOT (BARU) ---
use App\Http\Controllers\IotController;

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
| API ROUTES AGRI SMART (FULL IOT VERSION)
=======
| API ROUTES AGRI SMART (SYNCHRONIZED WITH WEB)
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
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

<<<<<<< HEAD
// --- RUTE IOT UNTUK ESP32 (WAJIB PUBLIC) ---
// ESP32 akan menembak ke sini: http://ip-address:8000/api/iot/receive
Route::post('/iot/receive', [IotController::class, 'receiveData']);


// 3. PRIVATE ROUTES (Wajib Login)
=======
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
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
Route::middleware('auth:sanctum')->group(function () {

    // --- USER INFO & LOGOUT ---
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user() // Mengambil data user yang sedang login
        ]);
    });
<<<<<<< HEAD

=======
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- PROFILE ---
    Route::post('/profile/update', [AuthController::class, 'updateProfile']); 
    Route::post('/profile/password', [AuthController::class, 'updatePassword']);

    // --- KERANJANG (CART) ---
    Route::get('/cart', [CartController::class, 'apiIndex']); 
    Route::post('/cart/add', [CartController::class, 'apiStore']); 
    Route::patch('/cart/update/{id}', [CartController::class, 'apiUpdate']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'apiDestroy']);

<<<<<<< HEAD
    // --- FITUR CHECKOUT & HISTORY ---
    Route::post('/checkout', [CheckoutController::class, 'apiProcess']);
    Route::get('/orders', [OrderController::class, 'index']);
=======
    // --- CHECKOUT & ORDER HISTORY (UMUM) ---
    Route::post('/checkout', [CheckoutController::class, 'apiProcess']); // Proses Pesanan
    Route::get('/orders', [OrderController::class, 'index']); // List Semua Order User Tersebut
    Route::get('/orders/{id}', [OrderController::class, 'show']); // Detail Order
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec

    // --- CHAT SYSTEM (MARKET & UMUM) ---
    // Chat Umum
    Route::get('/chat', [ChatController::class, 'apiIndex']); 
    Route::get('/chat/{id}', [ChatController::class, 'apiGetMessages']); 
    Route::post('/chat/send', [ChatController::class, 'apiSendMessage']); 
    
    // Market Chat (Sesuai Web)
    Route::get('/market-chat/list', [MarketChatController::class, 'getChatList']);
    Route::get('/market-chat/{receiver_id}', [MarketChatController::class, 'getMessages']);
    Route::post('/market-chat/send', [MarketChatController::class, 'sendMessage']);

<<<<<<< HEAD
    // --- FITUR PETANI (Khusus Role Petani) ---
    Route::middleware('role:petani')->group(function () {
        
        Route::get('/petani/dashboard', [PetaniProdukController::class, 'apiDashboard']);
        
        // Manajemen Produk Petani
=======
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
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
        Route::get('/petani/produk', [PetaniProdukController::class, 'apiIndex']);
        Route::post('/petani/produk/store', [PetaniProdukController::class, 'apiStore']);
        Route::post('/petani/produk/{id}', [PetaniProdukController::class, 'apiUpdate']); // Pakai POST untuk update file di Flutter
        Route::delete('/petani/produk/{id}', [PetaniProdukController::class, 'apiDestroy']);
<<<<<<< HEAD
        
        // Pesanan Masuk
        Route::get('/petani/pesanan', [PetaniPesananController::class, 'apiIndex']);
        Route::post('/petani/pesanan/{id}/update-status', [PetaniPesananController::class, 'apiUpdateStatus']);

        // --- MANAJEMEN ALAT IOT (PETANI) ---
        // Route ini dipakai Aplikasi HP Petani untuk kontrol alat
        Route::get('/petani/iot', [IotController::class, 'index']);        // List semua alat
        Route::post('/petani/iot/claim', [IotController::class, 'claimDevice']); // Klaim alat baru
        Route::post('/petani/iot/toggle/{id}', [IotController::class, 'togglePump']); // On/Off Pompa
        Route::post('/petani/iot/auto/{id}', [IotController::class, 'setAuto']); // Set ke Auto
=======

        // Manajemen Pesanan Masuk
        Route::get('/petani/pesanan', [PetaniPesananController::class, 'apiIndex']);
        Route::post('/petani/pesanan/{id}/update-status', [PetaniPesananController::class, 'apiUpdateStatus']);

        // Dompet Petani (Optional: Jika di Flutter mau ditampilkan)
        // Route::get('/petani/dompet', [PetaniDompetController::class, 'apiIndex']);
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
    });

    // ====================================================
    // 4. ROLE: KONSUMEN ROUTES
    // ====================================================
    Route::middleware('role:konsumen')->group(function () {
<<<<<<< HEAD
=======
        
        // Pesanan Konsumen (History & Tracking)
>>>>>>> 85f6429d533ce4c2349e1e5df46b7f23322a7fec
        Route::get('/konsumen/pesanan', [KonsumenPesananController::class, 'apiIndex']);
        
        // Cancel Pesanan
        Route::put('/konsumen/pesanan/{id}/cancel', [KonsumenPesananController::class, 'apiCancel']);
    });

});