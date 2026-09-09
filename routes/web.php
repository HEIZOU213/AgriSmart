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
use App\Http\Controllers\AuthOtpController; // <--- IMPOR CONTROLLER OTP (BARU)
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MarketChatController;
use App\Http\Controllers\KontakController;

// --- IMPOR IOT CONTROLLER (BARU) ---
use App\Http\Controllers\IotController;

// --- [PERBAIKAN 1] IMPOR MIDDLEWARE ACTIVITY ---
use App\Http\Middleware\UserActivity;

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

// Portal
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\Portal\PembibitanController;
use App\Http\Controllers\Portal\PertumbuhanController;
use App\Http\Controllers\Portal\ManajemenController;
use App\Http\Controllers\Portal\MarketplacePortalController;

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
    
    // --- LOGIN OTP ROUTES (BARU) ---
    Route::get('/login-otp', [AuthOtpController::class, 'showLoginForm'])->name('login.otp');
    Route::post('/login-otp', [AuthOtpController::class, 'loginWithPassword'])->name('login.otp.step1')->middleware('throttle:auth');
    Route::get('/verify-otp', [AuthOtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/verify-otp', [AuthOtpController::class, 'verifyOtp'])->name('otp.verify.submit')->middleware('throttle:auth');
    
    // [TAMBAHAN] Rute Kirim Ulang OTP via AJAX (POST)
    Route::post('/otp/resend', [AuthOtpController::class, 'resendOtp'])->name('otp.resend')->middleware('throttle:auth');
    // -------------------------------

    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'processRegister'])->middleware('throttle:auth');

    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'processLogin'])->middleware('throttle:auth');

    // --- LUPA PASSWORD OTP ROUTES (BARU) ---
    Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'sendResetOtp'])->name('password.email')->middleware('throttle:auth');
    Route::get('/reset-password-verify', [\App\Http\Controllers\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('/reset-password-verify', [\App\Http\Controllers\ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.submit')->middleware('throttle:auth');
    Route::get('/reset-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');
    // ---------------------------------------

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
                'role' => 'user',
                'password' => null,
            ]);
        }

        Auth::login($user, true);
        return redirect('/dashboard');
    })->name('socialite.google.callback');

    // Admin Login
    Route::get('/master-control/masuk', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/master-control/masuk', [AdminAuthController::class, 'login'])->name('admin.login.submit')->middleware('throttle:auth');
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

    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    // -----------------------------

    // Profil
    Route::get('/profile', [CustomAuthController::class, 'showProfile'])->name('profile.edit');
    Route::patch('/profile/info', [CustomAuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [CustomAuthController::class, 'updatePassword'])->name('password.update');

    // ====================================================
    // MARKET CHAT ROUTES (UPDATED)
    // ====================================================
    
    // Halaman List Chat (Inbox)
    Route::get('/chat', [MarketChatController::class, 'getChatList'])->name('chat.index');
    
    // Halaman Detail Chat (Room)
    Route::get('/chat/detail/{userId}', [MarketChatController::class, 'show'])->name('chat.show');

    // [BARU] Route khusus klik dari Produk (Jembatan ke chat.show)
    Route::get('/chat/product/{id}', [MarketChatController::class, 'chatWithProduct'])->name('chat.product');

    // API Internal Chat (AJAX untuk JS)
    Route::get('/ajax/chat/messages/{receiverId}', [MarketChatController::class, 'getMessages'])->name('ajax.chat.messages');
    Route::post('/ajax/chat/send', [MarketChatController::class, 'sendMessage'])->name('ajax.chat.send');
    
    // [TAMBAHAN BARU] Route khusus untuk set offline saat tutup tab
    Route::post('/chat/offline', [MarketChatController::class, 'setOffline'])->name('chat.offline');
    
    // ====================================================

    // Pesanan & Payment
    Route::get('/payment-finish', [CheckoutController::class, 'paymentFinish'])->name('payment.finish');
    Route::match(['post', 'put'], '/pesanan/{id}/cancel', [KonsumenPesanan::class, 'cancel'])->name('pesanan.cancel');
    Route::patch('/pesanan/{id}/selesai', [KonsumenPesanan::class, 'selesai'])->name('pesanan.selesai');

    // --- IOT SMART GARDEN (PEKEBUN & GLOBAL AUTH) ---
    Route::post('/layanan/claim', [IotController::class, 'claimDevice'])->name('layanan.claim');
    Route::get('/layanan/devices/template', [IotController::class, 'downloadTemplate'])->name('layanan.template');
    Route::post('/layanan/devices/upload', [IotController::class, 'uploadDevices'])->name('layanan.upload');
    Route::put('/layanan/devices/{id}', [IotController::class, 'updateDevice'])->name('layanan.update');
    Route::delete('/layanan/devices/{id}', [IotController::class, 'destroyDevice'])->name('layanan.destroy');
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
            case 'pekebun':
                return redirect()->route('portal.index'); // → Portal
            case 'user':
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
        Route::patch('/withdraw/{id}/reject', [WithdrawController::class, 'reject'])->name('withdraw.reject');
    });

    // 2. PETANI ROUTES (existing — tetap dipertahankan)
    Route::middleware(['role:pekebun'])->prefix('petani')->name('petani.')->group(function () {
        Route::get('/dashboard', [PetaniDashboard::class, 'index'])->name('dashboard');
        Route::resource('produk', PetaniProduk::class);
        Route::resource('pesanan', PetaniPesananController::class)->only(['index', 'show', 'update']);
        Route::get('/dompet', [DompetController::class, 'index'])->name('dompet.index');
        Route::post('/dompet', [DompetController::class, 'store'])->name('dompet.store');
        Route::get('/iot', fn() => redirect()->route('layanan.index'))->name('iot.index');
    });

    // 3. KONSUMEN ROUTES
    Route::middleware(['role:user'])->prefix('konsumen')->name('konsumen.')->group(function () {
        Route::resource('pesanan', KonsumenPesanan::class)->only(['index', 'show', 'destroy']);
        Route::put('/pesanan/{id}/cancel', [KonsumenPesanan::class, 'cancel'])->name('pesanan.cancel');
        Route::patch('/pesanan/{id}/selesai', [KonsumenPesanan::class, 'selesai'])->name('pesanan.selesai');
    });

    // ====================================================
    // PORTAL ROUTES (role: petani)
    // ====================================================
    Route::middleware(['role:pekebun'])->prefix('portal')->name('portal.')->group(function () {

        // ── Portal Selection ──────────────────────────────────
        Route::get('/', [PortalController::class, 'index'])->name('index');

        // ── Portal Pembibitan ─────────────────────────────────
        Route::prefix('pembibitan')->name('pembibitan.')->group(function () {
            Route::get('/', [PembibitanController::class, 'dashboard'])->name('dashboard');

            // Data Bibit
            Route::get('/bibit', [PembibitanController::class, 'bibitIndex'])->name('bibit.index');
            Route::get('/bibit/create', [PembibitanController::class, 'bibitCreate'])->name('bibit.create');
            Route::post('/bibit', [PembibitanController::class, 'bibitStore'])->name('bibit.store');
            Route::get('/bibit/{bibit}/edit', [PembibitanController::class, 'bibitEdit'])->name('bibit.edit');
            Route::put('/bibit/{bibit}', [PembibitanController::class, 'bibitUpdate'])->name('bibit.update');
            Route::delete('/bibit/{bibit}', [PembibitanController::class, 'bibitDestroy'])->name('bibit.destroy');
            Route::get('/bibit/{bibit}/tanam', [PembibitanController::class, 'tanamCreate'])->name('bibit.tanam.create');
            Route::post('/bibit/{bibit}/tanam', [PembibitanController::class, 'tanamStore'])->name('bibit.tanam.store');

            // Pengadaan
            Route::get('/pengadaan', [PembibitanController::class, 'pengadaanIndex'])->name('pengadaan.index');
            Route::get('/pengadaan/create', [PembibitanController::class, 'pengadaanCreate'])->name('pengadaan.create');
            Route::post('/pengadaan', [PembibitanController::class, 'pengadaanStore'])->name('pengadaan.store');
            Route::get('/pengadaan/{pengadaan}/edit', [PembibitanController::class, 'pengadaanEdit'])->name('pengadaan.edit');
            Route::put('/pengadaan/{pengadaan}', [PembibitanController::class, 'pengadaanUpdate'])->name('pengadaan.update');
            Route::delete('/pengadaan/{pengadaan}', [PembibitanController::class, 'pengadaanDestroy'])->name('pengadaan.destroy');

            // Monitoring
            Route::get('/monitoring', [PembibitanController::class, 'monitoringIndex'])->name('monitoring.index');
            Route::get('/monitoring/create', [PembibitanController::class, 'monitoringCreate'])->name('monitoring.create');
            Route::post('/monitoring', [PembibitanController::class, 'monitoringStore'])->name('monitoring.store');
            Route::get('/monitoring/{monitoring}/edit', [PembibitanController::class, 'monitoringEdit'])->name('monitoring.edit');
            Route::put('/monitoring/{monitoring}', [PembibitanController::class, 'monitoringUpdate'])->name('monitoring.update');
            Route::delete('/monitoring/{monitoring}', [PembibitanController::class, 'monitoringDestroy'])->name('monitoring.destroy');

            // Jadwal
            Route::get('/jadwal', [PembibitanController::class, 'jadwalIndex'])->name('jadwal.index');
            Route::get('/jadwal/create', [PembibitanController::class, 'jadwalCreate'])->name('jadwal.create');
            Route::post('/jadwal', [PembibitanController::class, 'jadwalStore'])->name('jadwal.store');
            Route::get('/jadwal/{jadwal}/edit', [PembibitanController::class, 'jadwalEdit'])->name('jadwal.edit');
            Route::put('/jadwal/{jadwal}', [PembibitanController::class, 'jadwalUpdate'])->name('jadwal.update');
            Route::delete('/jadwal/{jadwal}', [PembibitanController::class, 'jadwalDestroy'])->name('jadwal.destroy');
            Route::patch('/jadwal/{jadwal}/selesai', [PembibitanController::class, 'jadwalSelesai'])->name('jadwal.selesai');

            // Laporan
            Route::get('/laporan', [PembibitanController::class, 'laporan'])->name('laporan');
        });

        // ── Portal Pertumbuhan ────────────────────────────────
        Route::prefix('pertumbuhan')->name('pertumbuhan.')->group(function () {
            Route::get('/', [PertumbuhanController::class, 'dashboard'])->name('dashboard');

            // Data Pohon
            Route::get('/pohon', [PertumbuhanController::class, 'pohonIndex'])->name('pohon.index');
            Route::get('/pohon/create', [PertumbuhanController::class, 'pohonCreate'])->name('pohon.create');
            Route::post('/pohon', [PertumbuhanController::class, 'pohonStore'])->name('pohon.store');
            Route::get('/pohon/{pohon}/edit', [PertumbuhanController::class, 'pohonEdit'])->name('pohon.edit');
            Route::put('/pohon/{pohon}', [PertumbuhanController::class, 'pohonUpdate'])->name('pohon.update');
            Route::delete('/pohon/{pohon}', [PertumbuhanController::class, 'pohonDestroy'])->name('pohon.destroy');

            // Fase
            Route::get('/fase', [PertumbuhanController::class, 'fase'])->name('fase');

            // Monitoring
            Route::get('/monitoring', [PertumbuhanController::class, 'monitoringIndex'])->name('monitoring.index');
            Route::get('/monitoring/create', [PertumbuhanController::class, 'monitoringCreate'])->name('monitoring.create');
            Route::post('/monitoring', [PertumbuhanController::class, 'monitoringStore'])->name('monitoring.store');
            Route::get('/monitoring/{monitoring}/edit', [PertumbuhanController::class, 'monitoringEdit'])->name('monitoring.edit');
            Route::put('/monitoring/{monitoring}', [PertumbuhanController::class, 'monitoringUpdate'])->name('monitoring.update');
            Route::delete('/monitoring/{monitoring}', [PertumbuhanController::class, 'monitoringDestroy'])->name('monitoring.destroy');

            // Jadwal
            Route::get('/jadwal', [PertumbuhanController::class, 'jadwalIndex'])->name('jadwal.index');
            Route::get('/jadwal/create', [PertumbuhanController::class, 'jadwalCreate'])->name('jadwal.create');
            Route::post('/jadwal', [PertumbuhanController::class, 'jadwalStore'])->name('jadwal.store');
            Route::get('/jadwal/{jadwal}/edit', [PertumbuhanController::class, 'jadwalEdit'])->name('jadwal.edit');
            Route::put('/jadwal/{jadwal}', [PertumbuhanController::class, 'jadwalUpdate'])->name('jadwal.update');
            Route::delete('/jadwal/{jadwal}', [PertumbuhanController::class, 'jadwalDestroy'])->name('jadwal.destroy');
            Route::patch('/jadwal/{jadwal}/selesai', [PertumbuhanController::class, 'jadwalSelesai'])->name('jadwal.selesai');

            // Laporan
            Route::get('/laporan', [PertumbuhanController::class, 'laporan'])->name('laporan');
        });

        // ── Portal Manajemen Kebun ────────────────────────────
        Route::prefix('manajemen')->name('manajemen.')->group(function () {
            Route::get('/', [ManajemenController::class, 'dashboard'])->name('dashboard');

            // Lahan
            Route::get('/lahan', [ManajemenController::class, 'lahanIndex'])->name('lahan.index');
            Route::get('/lahan/create', [ManajemenController::class, 'lahanCreate'])->name('lahan.create');
            Route::post('/lahan', [ManajemenController::class, 'lahanStore'])->name('lahan.store');
            Route::get('/lahan/{lahan}/edit', [ManajemenController::class, 'lahanEdit'])->name('lahan.edit');
            Route::put('/lahan/{lahan}', [ManajemenController::class, 'lahanUpdate'])->name('lahan.update');
            Route::delete('/lahan/{lahan}', [ManajemenController::class, 'lahanDestroy'])->name('lahan.destroy');

            // Stok
            Route::get('/stok', [ManajemenController::class, 'stokIndex'])->name('stok.index');
            Route::get('/stok/create', [ManajemenController::class, 'stokCreate'])->name('stok.create');
            Route::post('/stok', [ManajemenController::class, 'stokStore'])->name('stok.store');
            Route::get('/stok/{stok}/edit', [ManajemenController::class, 'stokEdit'])->name('stok.edit');
            Route::put('/stok/{stok}', [ManajemenController::class, 'stokUpdate'])->name('stok.update');
            Route::delete('/stok/{stok}', [ManajemenController::class, 'stokDestroy'])->name('stok.destroy');

            // Panen
            Route::get('/panen', [ManajemenController::class, 'panenIndex'])->name('panen.index');
            Route::get('/panen/create', [ManajemenController::class, 'panenCreate'])->name('panen.create');
            Route::post('/panen', [ManajemenController::class, 'panenStore'])->name('panen.store');
            Route::get('/panen/{panen}/edit', [ManajemenController::class, 'panenEdit'])->name('panen.edit');
            Route::put('/panen/{panen}', [ManajemenController::class, 'panenUpdate'])->name('panen.update');
            Route::delete('/panen/{panen}', [ManajemenController::class, 'panenDestroy'])->name('panen.destroy');

            // Biaya
            Route::get('/biaya', [ManajemenController::class, 'biayaIndex'])->name('biaya.index');
            Route::get('/biaya/create', [ManajemenController::class, 'biayaCreate'])->name('biaya.create');
            Route::post('/biaya', [ManajemenController::class, 'biayaStore'])->name('biaya.store');
            Route::get('/biaya/{biaya}/edit', [ManajemenController::class, 'biayaEdit'])->name('biaya.edit');
            Route::put('/biaya/{biaya}', [ManajemenController::class, 'biayaUpdate'])->name('biaya.update');
            Route::delete('/biaya/{biaya}', [ManajemenController::class, 'biayaDestroy'])->name('biaya.destroy');

            // Jadwal
            Route::get('/jadwal', [ManajemenController::class, 'jadwalIndex'])->name('jadwal.index');
            Route::get('/jadwal/create', [ManajemenController::class, 'jadwalCreate'])->name('jadwal.create');
            Route::post('/jadwal', [ManajemenController::class, 'jadwalStore'])->name('jadwal.store');
            Route::get('/jadwal/{jadwal}/edit', [ManajemenController::class, 'jadwalEdit'])->name('jadwal.edit');
            Route::put('/jadwal/{jadwal}', [ManajemenController::class, 'jadwalUpdate'])->name('jadwal.update');
            Route::delete('/jadwal/{jadwal}', [ManajemenController::class, 'jadwalDestroy'])->name('jadwal.destroy');
            Route::patch('/jadwal/{jadwal}/selesai', [ManajemenController::class, 'jadwalSelesai'])->name('jadwal.selesai');

            // Laporan
            Route::get('/laporan', [ManajemenController::class, 'laporan'])->name('laporan');
        });

        // ── Portal Marketplace ────────────────────────────────
        Route::prefix('marketplace')->name('marketplace.')->group(function () {
            Route::get('/', [MarketplacePortalController::class, 'dashboard'])->name('dashboard');
        });
    });

    // Realtime Notifikasi (Polling Web)
    Route::get('/api/cek-notifikasi', [ChatController::class, 'checkNotifications'])->name('api.cek-notifikasi');

});