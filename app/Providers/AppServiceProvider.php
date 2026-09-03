<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use App\Models\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // PENCEGAHAN BRUTE FORCE LOGIN & OTP
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
        // PERUBAHAN DI SINI:
        // Gunakan 'components.navbar' karena file ada di folder components
        View::composer('*', function ($view) {
            $cartCount = 0;
            
            if (Auth::check()) {
                $cartCount = Keranjang::where('user_id', Auth::id())->count();
            }

            $view->with('cartCount', $cartCount);
        });
    }
}