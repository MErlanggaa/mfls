<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ✅ Pakai CORS bawaan Laravel 11
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        // Proxy trust
        $middleware->trustProxies(at: '*');

        // Alias middleware lain
        $middleware->alias([
            'survey.check' => \App\Http\Middleware\EnsureSurveyIsFilled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();