<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Import Controller ---
use App\Http\Controllers\Api\PaymentCallbackController; 
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProdukController;
// Tambahkan controller Edukasi agar tidak error
use App\Http\Controllers\EdukasiController; 

/*
|--------------------------------------------------------------------------
| API ROUTES
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PAYMENT GATEWAY (SANGAT PENTING)
// ==========================================
// Route ini menerima sinyal dari Midtrans saat pembayaran sukses
Route::post('midtrans-callback', [PaymentCallbackController::class, 'handle']);


// ==========================================
// 2. JALUR PUBLIK (Bisa diakses siapa saja)
// ==========================================

// Login HP
Route::post('/login', [AuthController::class, 'login']);

// Ambil Data Produk (Untuk Home Screen)
Route::get('/produk', [ProdukController::class, 'apiIndex']);

// Ambil Data Edukasi/Artikel (Untuk Menu Edukasi)
Route::get('/edukasi', [EdukasiController::class, 'apiIndex']);


// ==========================================
// 3. JALUR PRIBADI (Wajib Login / Punya Token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil Data Profil User Sendiri (Nama, Email, dll)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Nanti bisa tambah route Cart/Keranjang disini
});