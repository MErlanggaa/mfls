<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSurveyIsFilled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'pendaftar') {
            // Check if user has filled survey
            $hasSurvey = \App\Models\Survei::where('akun_id', Auth::id())->exists();
            
            // If not filled and not currently on survey page
            if (!$hasSurvey && !$request->is('survey') && !$request->is('logout')) {
                return redirect('/survey');
            }

            // If filled and accessing survey page, redirect to dashboard
            if ($hasSurvey && $request->is('survey')) {
                return redirect('/pendaftar/dashboard');
            }
        }

        return $next($request);
    }
}
