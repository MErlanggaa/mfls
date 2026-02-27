<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $userRole = strtolower(trim($user->role));
        
        // Split roles if they came as a single string (some Laravel versions/config)
        $allowedRoles = [];
        foreach ($roles as $role) {
            $parts = explode(',', $role);
            foreach ($parts as $part) {
                $allowedRoles[] = strtolower(trim($part));
            }
        }

        // If 'pendaftar' tries to access non-pendaftar restricted areas, redirect to their profile
        if ($userRole === 'pendaftar' && !in_array('pendaftar', $allowedRoles)) {
            return redirect()->route('pendaftar.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        // Check if user has any of the required roles
        if (!in_array($userRole, $allowedRoles)) {
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
