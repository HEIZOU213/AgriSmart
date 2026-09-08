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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek login
        if (!Auth::check()) {
            abort(403, 'ANDA TIDAK PUNYA AKSES KE HALAMAN INI.');
        }

        $userRole = Auth::user()->role;
        // Normalisasi alias legacy jika ada
        if ($userRole === 'petani') $userRole = 'pekebun';
        if ($userRole === 'konsumen') $userRole = 'user';

        // 2. Kumpulkan role yang diizinkan (mendukung role tunggal atau koma)
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $r = trim($r);
                if ($r === 'petani') $r = 'pekebun';
                if ($r === 'konsumen') $r = 'user';
                $allowedRoles[] = $r;
            }
        }

        // 3. Cek apakah role user termasuk dalam role yang diizinkan
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'ANDA TIDAK PUNYA AKSES KE HALAMAN INI.');
        }

        return $next($request);
    }
}