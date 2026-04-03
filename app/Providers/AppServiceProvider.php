<?php

namespace App\Providers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom public path for Hostinger (parallel public_html folder)
        $publicHtmlPath = base_path('../public_html');
        if (is_dir($publicHtmlPath)) {
            $this->app->usePublicPath($publicHtmlPath);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Register Google Sheets Sync Observers
        \App\Models\Akun::observe(\App\Observers\GoogleSheetObserver::class);
        \App\Models\Peserta::observe(\App\Observers\GoogleSheetObserver::class);
        \App\Models\Nilai::observe(\App\Observers\NilaiObserver::class);
        \App\Models\Nilai::observe(\App\Observers\GoogleSheetObserver::class);
        \App\Models\Berkas::observe(\App\Observers\GoogleSheetObserver::class);
        \App\Models\Daftar::observe(\App\Observers\GoogleSheetObserver::class);
    }
}
