<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// --- Impor Tambahan untuk Socialite ---
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
// -------------------------------------

// --- Impor Controller ---
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesanOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

// --- IMPOR IOT CONTROLLER (BARU) ---
use App\Http\Controllers\IotController;

// Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KontenEdukasiController as AdminKontenEdukasi;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\WithdrawController;

// Petani
use App\Http\Controllers\Petani\DashboardController as PetaniDashboard;
use App\Http\Controllers\Petani\ProdukController as PetaniProduk;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Petani\DompetController;

// Konsumen
use App\Http\Controllers\Konsumen\PesananController as KonsumenPesanan;

/*
|--------------------------------------------------------------------------
| BAGIAN 1: RUTE PUBLIK & GUEST
|--------------------------------------------------------------------------
*/

// Halaman Publik (Bisa diakses siapa saja)
Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/tentang', [AboutController::class, 'index'])->name('tentang.index');
Route::get('/edukasi', [EdukasiController::class, 'index'])->name('edukasi.index');
Route::get('/edukasi/{slug}', [EdukasiController::class, 'show'])->name('edukasi.show');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

// --- LAYANAN SMART GARDEN IOT (FRONTEND BARU) ---
Route::get('/layanan/smart-garden', [IotController::class, 'serviceIndex'])->name('layanan.index');
Route::get('/layanan/smart-garden/{serial_number}', [IotController::class, 'serviceShow'])->name('layanan.show');

// Form Kontak
Route::get('/kontak', [KontakController::class, 'show'])->name('kontak.show');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// --- AUTHENTICATION (GUEST ONLY) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'processRegister']);

    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'processLogin']);

    // Socialite Google
    Route::get('/auth/google/redirect', function () {
        return Socialite::driver('google')->redirect();
    })->name('socialite.google.redirect');

    Route::get('/auth/callback', function () {
        try {
            $socialiteUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['socialite' => 'Otentikasi Google gagal. Silakan coba lagi.']);
        }

        $email = $socialiteUser->getEmail();
        $googleId = $socialiteUser->getId();
        $provider = 'google';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->provider = $provider;
            $user->provider_id = $googleId;
            $user->foto_profil = $socialiteUser->getAvatar();
            $user->save();
        } else {
            $user = User::create([
                'name' => $socialiteUser->getName() ?? explode('@', $email)[0],
                'email' => $email,
                'provider' => $provider,
                'provider_id' => $googleId,
                'foto_profil' => $socialiteUser->getAvatar(),
                'email_verified_at' => now(),
                'role' => 'konsumen',
                'password' => null,
            ]);
        }

        Auth::login($user, true);
        return redirect('/dashboard');
    })->name('socialite.google.callback');

    // Admin Login
    Route::get('/master-control/masuk', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/master-control/masuk', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

/*
|--------------------------------------------------------------------------
| BAGIAN 2: RUTE TERPROTEKSI (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

    // --- [BARU] LOGIKA REDIRECT LOGIN KHUSUS HALAMAN LAYANAN ---
    Route::get('/layanan-auth-redirect', function () {
        return redirect()->route('layanan.index');
    })->name('layanan.auth.check');
    // ------------------------------------------------------------

    // Keranjang & Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // --- ROUTES CART (UPDATED) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.store');

    // [PENTING] Route Baru untuk AJAX Update Quantity
    Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantityAjax'])->name('cart.update.ajax');

    // Route lama 'patch' dimatikan karena method 'update' sudah dihapus di Controller
    // Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    // -----------------------------

    // Profil
    Route::get('/profile', [CustomAuthController::class, 'showProfile'])->name('profile.edit');
    Route::patch('/profile/info', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomAuthController::class, 'updatePassword'])->name('password.update');

    // Chat
    Route::get('/api/cek-notifikasi', [ChatController::class, 'checkNotifications'])->name('api.notifikasi');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/api/chat/{id}/messages', [ChatController::class, 'getMessages'])->name('api.chat.messages');
    Route::post('/api/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('api.chat.send');
    Route::delete('/chat/{id}', [ChatController::class, 'destroy'])->name('chat.destroy');
    Route::post('/pesan-order/{id}', [PesanOrderController::class, 'store'])->name('pesan.store');

    // Pesanan & Payment
    Route::get('/payment-finish', [CheckoutController::class, 'paymentFinish'])->name('payment.finish');
    Route::post('/pesanan/{id}/cancel', [CheckoutController::class, 'cancelOrder'])->name('pesanan.cancel');

    // --- IOT SMART GARDEN (GLOBAL AUTH) ---
    Route::post('/layanan/claim', [IotController::class, 'claimDevice'])->name('layanan.claim');
    Route::post('/iot/toggle/{id}', [IotController::class, 'togglePump'])->name('iot.toggle');
    Route::post('/iot/auto/{id}', [IotController::class, 'setAuto'])->name('iot.auto');
    
    // [FIXED] Menambahkan Route Manual yang sebelumnya hilang
    Route::post('/iot/manual/{id}', [IotController::class, 'manual'])->name('iot.manual');

    // [TAMBAHAN] Rute Khusus untuk AJAX Real-Time Data (Tanpa Refresh)
    Route::get('/iot/data/{serial_number}', [IotController::class, 'getLatestData'])->name('iot.data');

    // Redirect Dashboard
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petani':
                return redirect()->route('petani.dashboard');
            case 'konsumen':
                return redirect()->route('homepage');
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
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/api/notifikasi', [AdminController::class, 'cekNotifikasi'])->name('api.notifikasi');
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('konten-edukasi', AdminKontenEdukasi::class);
        Route::get('/users/petani', [AdminUserController::class, 'listPetani'])->name('users.petani');
        Route::get('/users/konsumen', [AdminUserController::class, 'listKonsumen'])->name('users.konsumen');
        Route::resource('users', AdminUserController::class);
        Route::get('/inbox', [KontakController::class, 'index'])->name('kontak.index');
        Route::delete('/inbox/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');
        Route::resource('products', AdminProductController::class)->except(['create', 'store', 'show']);
        Route::get('/withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
        Route::patch('/withdraw/{id}/approve', [WithdrawController::class, 'approve'])->name('withdraw.approve');
    });

    // 2. PETANI ROUTES
    Route::middleware(['role:petani'])->prefix('petani')->name('petani.')->group(function () {
        Route::get('/dashboard', [PetaniDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', PetaniProduk::class);
        Route::resource('pesanan', PetaniPesananController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::get('/dompet', [DompetController::class, 'index'])->name('dompet.index');
        Route::post('/dompet', [DompetController::class, 'store'])->name('dompet.store');

        // Dashboard Internal IoT (List)
        Route::get('/iot', [IotController::class, 'index'])->name('iot.index');
    });

    // 3. KONSUMEN ROUTES
    Route::middleware(['role:konsumen'])->prefix('konsumen')->name('konsumen.')->group(function () {
        Route::resource('pesanan', KonsumenPesanan::class);
        Route::put('/pesanan/{id}/cancel', [KonsumenPesanan::class, 'cancel'])->name('pesanan.cancel');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

});