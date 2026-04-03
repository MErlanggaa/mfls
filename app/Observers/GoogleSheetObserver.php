<?php

namespace App\Observers;

use App\Jobs\SyncGoogleSheetJob;

class GoogleSheetObserver
{
    /**
     * Handle the "saved" event.
     */
    public function saved(): void
    {
        if (app()->runningInConsole()) return;
        \App\Jobs\SyncGoogleSheetJob::dispatch();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(): void
    {
        if (app()->runningInConsole()) return;
        \App\Jobs\SyncGoogleSheetJob::dispatch();
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(): void
    {
        if (app()->runningInConsole()) return;
        \App\Jobs\SyncGoogleSheetJob::dispatch();
    }

    /**
     * Handle the "forceDeleted" event.
     */
    public function forceDeleted(): void
    {
        if (app()->runningInConsole()) return;
        \App\Jobs\SyncGoogleSheetJob::dispatch();
    }
}
