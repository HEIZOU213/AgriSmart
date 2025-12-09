<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// --- Impor Controller ---
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesanOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProfileController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KontenEdukasiController as AdminKontenEdukasi;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AdminAuthController; // Pastikan controller ini ada

// Petani
use App\Http\Controllers\Petani\DashboardController as PetaniDashboard;
use App\Http\Controllers\Petani\ProdukController as PetaniProduk;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;

// Konsumen
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesanan;

/*
|--------------------------------------------------------------------------
| BAGIAN 1: RUTE PUBLIK & GUEST
|--------------------------------------------------------------------------
*/

// Halaman Publik (Bisa diakses siapa saja)
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

// Form Kontak
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// --- AUTHENTICATION (GUEST ONLY) ---
Route::middleware('guest')->group(function () {
    // Register User Biasa
    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'processRegister']);

    // Login User Biasa (Petani/Konsumen)
    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'processLogin']);

    // --- RAHASIA: LOGIN KHUSUS ADMIN ---
    // URL ini tidak boleh ketahuan publik
    Route::get('/master-control/masuk', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/master-control/masuk', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

/*
|--------------------------------------------------------------------------
| BAGIAN 2: RUTE TERPROTEKSI (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Logout (Wajib Login dulu baru bisa logout)
    Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // Keranjang & Profil
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Profil User
    Route::get('/profile', [CustomAuthController::class, 'showProfile'])->name('profile.edit');
    Route::patch('/profile/info', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomAuthController::class, 'updatePassword'])->name('password.update');

    // Fitur Chat & Pesan
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/api/chat/{id}/messages', [ChatController::class, 'getMessages'])->name('api.chat.messages');
    Route::post('/api/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
    Route::post('/pesan-order/{id}', [PesanOrderController::class, 'store'])->name('pesan.store');

    // --- LOGIC REDIRECT DASHBOARD ---
    // Route ini menangani kemana user pergi setelah login/klik dashboard
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petani':
                return redirect()->route('petani.dashboard');
            case 'konsumen':
                return redirect()->route('homepage'); // Atau ke riwayat pesanan
            default:
                return redirect('/');
        }
    })->name('dashboard');

    // Verifikasi Email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');


    // ====================================================
    // GROUP ROUTES BERDASARKAN ROLE
    // ====================================================

    // 1. ADMIN ROUTES
    // Prefix saya ganti jadi 'master-control' biar konsisten dengan loginnya (OPSIONAL)
    // Kalau mau tetap 'admin', ubah prefix('master-control') jadi prefix('admin')
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Ini adalah route 'admin.dashboard' yang ASLI (Pakai Controller)
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard'); 
        
        Route::resource('konten-edukasi', AdminKontenEdukasi::class);
        Route::get('/users/petani', [AdminUserController::class, 'listPetani'])->name('users.petani');
        Route::get('/users/konsumen', [AdminUserController::class, 'listKonsumen'])->name('users.konsumen');
        Route::resource('users', AdminUserController::class);
        Route::get('/inbox', [KontakController::class, 'index'])->name('kontak.index');
        Route::delete('/inbox/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');
        Route::resource('products', AdminProductController::class)->except(['create', 'store', 'show']);
    });

    // 2. PETANI ROUTES
    Route::middleware(['role:petani'])->prefix('petani')->name('petani.')->group(function () {
        Route::get('/dashboard', [PetaniDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', PetaniProduk::class);
        Route::resource('pesanan', PetaniPesananController::class)->only(['index', 'show', 'update']);
    });

    // 3. KONSUMEN ROUTES
    Route::middleware(['role:konsumen'])->prefix('konsumen')->name('konsumen.')->group(function () {
        Route::resource('pesanan', KonsumenPesanan::class);
        // Checkout & Pembatalan
        Route::put('/pesanan/{id}/cancel', [KonsumenPesanan::class, 'cancel'])->name('pesanan.cancel');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); // Nama diperbaiki (konsumen.checkout.index)
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

});