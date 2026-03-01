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
        
        $allowedRoles = [];
        $allowedEmails = [];

        foreach ($roles as $role) {
            $parts = explode(',', $role);
            foreach ($parts as $part) {
                $trimmedPart = strtolower(trim($part));
                if (str_starts_with($trimmedPart, 'email:')) {
                    $emailList = substr($trimmedPart, 6);
                    $emails = explode('|', $emailList);
                    foreach ($emails as $e) {
                        $allowedEmails[] = trim($e);
                    }
                } else {
                    $allowedRoles[] = $trimmedPart;
                }
            }
        }

        // If 'pendaftar' tries to access non-pendaftar restricted areas, or vice versa, show 404
        if (!empty($allowedRoles) && !in_array($userRole, $allowedRoles)) {
            abort(404);
        }

        // If specific emails are required, check them
        if (!empty($allowedEmails) && !in_array($user->email, $allowedEmails)) {
            abort(404);
        }

        return $next($request);
    }
}
