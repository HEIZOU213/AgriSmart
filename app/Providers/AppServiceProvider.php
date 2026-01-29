<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Penting
use Illuminate\Support\Facades\Auth; // Penting
use App\Models\Keranjang;            // Penting

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