<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Pastikan ini adalah instance dari Illuminate\Http\Response sebelum memodifikasi header
        // karena kadang Response bisa berupa BinaryFileResponse (download) atau JsonResponse
        if (method_exists($response, 'header')) {
            $response->header('X-Frame-Options', 'SAMEORIGIN'); // Mencegah Clickjacking
            $response->header('X-XSS-Protection', '1; mode=block'); // Mencegah XSS (Browser Kuno)
            $response->header('X-Content-Type-Options', 'nosniff'); // Mencegah MIME Sniffing
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin'); // Melindungi referer
            
            // Opsional: CSP (Content Security Policy). Kita skip CSP strict untuk menghindari pecahnya 
            // script inline seperti tailwind CDN atau script custom. 
            // $response->header('Content-Security-Policy', "default-src 'self'");
        }

        return $response;
    }
}
