<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Impor Auth
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Parameter role yang kita kirim
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login DAN
        // 2. Cek apakah role user SAMA DENGAN role yang dibutuhkan
        if (!Auth::check() || Auth::user()->role !== $role) {
            
            // 3. Jika tidak, "tendang" mereka ke halaman 403 (Forbidden)
            abort(403, 'ANDA TIDAK PUNYA AKSES KE HALAMAN INI.');
        }

        // 4. Jika lolos, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}