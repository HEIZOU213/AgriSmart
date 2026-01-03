<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Import Semua Controller ---
use App\Http\Controllers\Api\PaymentCallbackController; 
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController; 

// Import Controller Petani & Konsumen
use App\Http\Controllers\Petani\ProdukController as PetaniProdukController;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesananController;

// --- IMPORT CONTROLLER IOT (BARU) ---
use App\Http\Controllers\IotController;

/*
|--------------------------------------------------------------------------
| API ROUTES AGRI SMART (FULL IOT VERSION)
|--------------------------------------------------------------------------
*/

// 1. PAYMENT GATEWAY (JANGAN DIHAPUS)
Route::post('midtrans-callback', [PaymentCallbackController::class, 'handle']);

// 2. PUBLIC ROUTES (Tanpa Login)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); 
Route::get('/produk', [ProdukController::class, 'apiIndex']);
Route::get('/produk/{id}', [ProdukController::class, 'apiShow']); 
Route::get('/edukasi', [EdukasiController::class, 'apiIndex']);
Route::get('/edukasi/{slug}', [EdukasiController::class, 'apiShow']);

// --- RUTE IOT UNTUK ESP32 (WAJIB PUBLIC) ---
// ESP32 akan menembak ke sini: http://ip-address:8000/api/iot/receive
Route::post('/iot/receive', [IotController::class, 'receiveData']);


// 3. PRIVATE ROUTES (Wajib Login)
Route::middleware('auth:sanctum')->group(function () {
    
    // --- FITUR UMUM USER (Profil, Logout) ---
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']); 

    // --- FITUR KERANJANG (CART) ---
    Route::get('/cart', [CartController::class, 'apiIndex']); 
    Route::post('/cart/add', [CartController::class, 'apiStore']); 
    Route::delete('/cart/remove/{id}', [CartController::class, 'apiDestroy']);

    // --- FITUR CHECKOUT & HISTORY ---
    Route::post('/checkout', [CheckoutController::class, 'apiProcess']);
    Route::get('/orders', [OrderController::class, 'index']);

    // --- FITUR CHAT ---
    Route::get('/chat', [ChatController::class, 'apiIndex']); 
    Route::get('/chat/{id}/messages', [ChatController::class, 'apiGetMessages']); 
    Route::post('/chat/send', [ChatController::class, 'apiSendMessage']); 

    // --- FITUR PETANI (Khusus Role Petani) ---
    Route::middleware('role:petani')->group(function () {
        
        Route::get('/petani/dashboard', [PetaniProdukController::class, 'apiDashboard']);
        
        // Manajemen Produk Petani
        Route::get('/petani/produk', [PetaniProdukController::class, 'apiIndex']);
        Route::post('/petani/produk', [PetaniProdukController::class, 'apiStore']);
        Route::post('/petani/produk/{id}', [PetaniProdukController::class, 'apiUpdate']); 
        Route::delete('/petani/produk/{id}', [PetaniProdukController::class, 'apiDestroy']);
        
        // Pesanan Masuk
        Route::get('/petani/pesanan', [PetaniPesananController::class, 'apiIndex']);
        Route::post('/petani/pesanan/{id}/update-status', [PetaniPesananController::class, 'apiUpdateStatus']);

        // --- MANAJEMEN ALAT IOT (PETANI) ---
        // Route ini dipakai Aplikasi HP Petani untuk kontrol alat
        Route::get('/petani/iot', [IotController::class, 'index']);        // List semua alat
        Route::post('/petani/iot/claim', [IotController::class, 'claimDevice']); // Klaim alat baru
        Route::post('/petani/iot/toggle/{id}', [IotController::class, 'togglePump']); // On/Off Pompa
        Route::post('/petani/iot/auto/{id}', [IotController::class, 'setAuto']); // Set ke Auto
    });

    // --- FITUR KONSUMEN (Khusus Role Konsumen) ---
    Route::middleware('role:konsumen')->group(function () {
        Route::get('/konsumen/pesanan', [KonsumenPesananController::class, 'apiIndex']);
        Route::get('/konsumen/pesanan/{id}', [KonsumenPesananController::class, 'apiShow']);
    });

});