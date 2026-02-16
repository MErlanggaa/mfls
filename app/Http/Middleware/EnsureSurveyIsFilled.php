<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSurveyIsFilled
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. JANGAN CEK APAPUN JIKA REQUEST ADALAH 'OPTIONS' (Preflight)
        if ($request->isMethod('OPTIONS')) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->role === 'pendaftar') {
            $hasSurvey = \App\Models\Survei::where('akun_id', Auth::id())->exists();
            
            // 2. JANGAN REDIRECT JIKA REQUEST ADALAH API
            if (!$hasSurvey && !$request->is('survey', 'logout', 'api/*')) {
                // Jika butuh response JSON untuk frontend
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json(['message' => 'Silakan isi survei terlebih dahulu.'], 403);
                }
                return redirect('/survey');
            }

            if ($hasSurvey && $request->is('survey')) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json(['message' => 'Survei sudah diisi.'], 200);
                }
                return redirect('/pendaftar/dashboard');
            }
        }

        return $next($request);
    }
}
