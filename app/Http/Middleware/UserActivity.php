<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache; // [TAMBAH INI]
use Carbon\Carbon;

class UserActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Pengecekan standar
        if (Auth::check() && !$request->routeIs('chat.offline')) {
            $user = Auth::user();
            $user->last_seen = Carbon::now();
            $user->save();

            // [TAMBAHAN PENTING]
            // Jika user melakukan aktivitas apa pun (klik, refresh, polling chat),
            // HAPUS tanda 'force-offline' di cache agar dia langsung terdeteksi ONLINE lagi.
            if (Cache::has('user-force-offline-' . $user->id)) {
                Cache::forget('user-force-offline-' . $user->id);
            }
        }

        return $next($request);
    }
}