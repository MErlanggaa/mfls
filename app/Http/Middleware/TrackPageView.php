<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin routes, API routes, and assets
        if (
            $request->is('admin/*') || 
            $request->is('api/*') || 
            $request->is('storage/*') ||
            $request->is('icon/*')
        ) {
            return $next($request);
        }

        // Track the page view
        PageView::create([
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'user_id' => auth()->id(),
            'viewed_at' => now(),
        ]);

        return $next($request);
    }
}
