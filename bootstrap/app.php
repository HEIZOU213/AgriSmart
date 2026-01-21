<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Impor middleware
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\UserActivity; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Alias Route
        $middleware->alias([
            'role' => CheckRole::class,
        ]);

        // 2. Middleware Aktivitas User (Last Seen)
        
        // A. Untuk Website (Browser)
        $middleware->appendToGroup('web', UserActivity::class);

        // B. Untuk Mobile App (API) -- TAMBAHKAN BARIS INI
        $middleware->appendToGroup('api', UserActivity::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();