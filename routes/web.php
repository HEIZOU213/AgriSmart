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
use App\Http\Controllers\PesanOrderController; // Pastikan ini ada
use App\Http\Controllers\ChatController;

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
use App\Http\Controllers\Konsumen\DashboardController as KonsumenDashboard;


/*
|--------------------------------------------------------------------------
| BAGIAN 1: RUTE PUBLIK & TAMU (TIDAK PERLU LOGIN)
|--------------------------------------------------------------------------
*/

// --- Auth Manual (Login & Register) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'processRegister']);
    
    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'processLogin']);
});

// Logout
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

// Halaman Publik Lainnya
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

    // Di dalam routes/web.php (di dalam group auth)

// --- FITUR CHAT REALTIME ---
Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');

// API Routes untuk AJAX (Digunakan oleh JavaScript)
Route::get('/api/chat/{id}/messages', [chatController::class, 'getMessages'])->name('api.chat.messages');
Route::post('/api/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');

Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');

    // Aksi Keranjang
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // [PERBAIKAN: Rute Chat diletakkan di sini agar Petani & Konsumen bisa akses]
    Route::post('/pesan-order/{id}', [PesanOrderController::class, 'store'])->name('pesan.store');

    // Dashboard Redirector
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin': return redirect()->route('admin.dashboard');
            case 'petani': return redirect()->route('petani.dashboard');
            case 'konsumen': return redirect()->route('produk.index'); 
            default: return redirect('/'); 
        }
    })->name('dashboard');

    // Rute Profil Manual
    Route::get('/profile', [CustomAuthController::class, 'showProfile'])->name('profile.edit');
    Route::patch('/profile/info', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomAuthController::class, 'updatePassword'])->name('password.update');

    // Rute Verifikasi
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['throttle:6,1'])->name('verification.send');


    // --- Admin Routes ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('konten-edukasi', AdminKontenEdukasi::class);
        Route::resource('users', AdminUserController::class);
    });

    // --- Petani Routes ---
    Route::middleware(['role:petani'])->prefix('petani')->name('petani.')->group(function () {
        Route::get('/dashboard', [PetaniDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', PetaniProduk::class);
        Route::resource('pesanan', PetaniPesananController::class)->only(['index', 'show', 'update']); 
    });

    // --- Konsumen Routes ---
    Route::middleware(['role:konsumen'])->prefix('konsumen')->name('konsumen.')->group(function () {
        // Rute chat sudah dipindah ke atas agar Petani juga bisa akses
        Route::resource('pesanan', KonsumenPesanan::class);
    });

    // Checkout (Khusus Konsumen, tapi nama route netral)
    Route::middleware(['role:konsumen'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });
});