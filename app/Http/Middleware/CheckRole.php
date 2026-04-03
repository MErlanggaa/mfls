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

        // Role and Email matching logic
        $roleMatched = empty($allowedRoles) || in_array($userRole, $allowedRoles);
        $emailMatched = empty($allowedEmails) || in_array($user->email, $allowedEmails);

        // If both are specified, we allow if either matches (OR logic)
        // Adjust: If both are specified, it's actually an OR in this context for "Akademik OR specific admins"
        // However, standard Laravel middleware usually treats multiple arguments as MUST match if any.
        // Let's stick to the "any match is allowed" if we want to support this specific case.
        
        if (!$roleMatched && !$emailMatched) {
            abort(404);
        }

        return $next($request);
    }
}
