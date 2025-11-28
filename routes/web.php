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
use App\Http\Controllers\ChatController;       // [FIX 1] Tambahkan Import ini
use App\Http\Controllers\KontakController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KontenEdukasiController as AdminKontenEdukasi;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Petani
use App\Http\Controllers\Petani\DashboardController as PetaniDashboard;
use App\Http\Controllers\Petani\ProdukController as PetaniProduk;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;

// Konsumen
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesanan;


/*
|--------------------------------------------------------------------------
| BAGIAN 1: RUTE PUBLIK & TAMU
|--------------------------------------------------------------------------
*/

// Form Kontak (Publik)
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// Auth Manual
Route::middleware('guest')->group(function () {
    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'processRegister']);
    
    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'processLogin']);
});

Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

// Halaman Publik
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


/*
|--------------------------------------------------------------------------
| BAGIAN 2: RUTE TERPROTEKSI (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- Fitur Chat Realtime ---
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    
    // API Routes (AJAX)
    // [FIX 2] Ubah chatController menjadi ChatController (Kapital)
    Route::get('/api/chat/{id}/messages', [ChatController::class, 'getMessages'])->name('api.chat.messages');
    Route::post('/api/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');
    
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');

    // Aksi Keranjang
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Kirim pesan dari detail order
    Route::post('/pesan-order/{id}', [PesanOrderController::class, 'store'])->name('pesan.store');

    // Dashboard Redirector
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin': return redirect()->route('admin.dashboard');
            case 'petani': return redirect()->route('petani.dashboard');
            case 'konsumen': return redirect()->route('homepage'); 
            default: return redirect('/'); 
        }
    })->name('dashboard');

    // Profil
    Route::get('/profile', [CustomAuthController::class, 'showProfile'])->name('profile.edit');
    Route::patch('/profile/info', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomAuthController::class, 'updatePassword'])->name('password.update');

    // Verifikasi Email (Opsional)
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');


    // --- Admin Routes ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('konten-edukasi', AdminKontenEdukasi::class);

        // [KODE BARU] Rute Khusus Daftar Petani & Konsumen
        Route::get('/users/petani', [AdminUserController::class, 'listPetani'])->name('users.petani');
        Route::get('/users/konsumen', [AdminUserController::class, 'listKonsumen'])->name('users.konsumen');

        // Resource Users (CRUD standar)
        Route::resource('users', AdminUserController::class);
        
        Route::get('/inbox', [KontakController::class, 'index'])->name('kontak.index');
        Route::delete('/inbox/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');
    });

    // --- Petani Routes ---
    Route::middleware(['role:petani'])->prefix('petani')->name('petani.')->group(function () {
        Route::get('/dashboard', [PetaniDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', PetaniProduk::class);
        Route::resource('pesanan', PetaniPesananController::class)->only(['index', 'show', 'update']); 
    });

    // --- Konsumen Routes ---
    Route::middleware(['role:konsumen'])->prefix('konsumen')->name('konsumen.')->group(function () {
        Route::resource('pesanan', KonsumenPesanan::class);
    });

    // Checkout
    Route::middleware(['role:konsumen'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});