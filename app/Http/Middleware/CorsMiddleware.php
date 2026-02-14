<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Tangani Preflight Request (OPTIONS)
        if ($request->isMethod('OPTIONS')) {
            return response('', 204) // 204 No Content lebih standar untuk OPTIONS
                ->header('Access-Control-Allow-Origin', '*') // Ganti * dengan domain React kamu nanti
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept');
        }

        $response = $next($request);

        // Tambahkan header ke response asli
        return $response
            ->header('Access-Control-Allow-Origin', '*') 
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept');
    }
}