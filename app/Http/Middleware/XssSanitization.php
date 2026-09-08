<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitization
{
    /**
     * Field yang dikecualikan dari strip_tags (misal password agar tidak korup, isi_konten artikel edukasi)
     */
    protected array $except = [
        'password',
        'password_confirmation',
        'current_password',
        'isi_konten',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function(&$value, $key) {
            if (is_string($value) && !in_array($key, $this->except, true)) {
                $value = strip_tags($value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
