<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;

class GoogleSheetObserver
{
    /**
     * Handle the "saved" event.
     */
    public function saved(): void
    {
        if (app()->runningInConsole()) return;
        $this->safeSync();
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(): void
    {
        if (app()->runningInConsole()) return;
        $this->safeSync();
    }

    /**
     * Handle the "restored" event.
     */
    public function restored(): void
    {
        if (app()->runningInConsole()) return;
        $this->safeSync();
    }

    /**
     * Handle the "forceDeleted" event.
     */
    public function forceDeleted(): void
    {
        if (app()->runningInConsole()) return;
        $this->safeSync();
    }

    /**
     * Run sync safely — tangkap error quota/rate-limit Google API
     * agar tidak menyebabkan HTTP 500 pada request utama.
     */
    protected function safeSync(): void
    {
        try {
            (new \App\Services\GoogleSheetService())->syncAll();
        } catch (\Google\Service\Exception $e) {
            // 429 = Quota exceeded — catat sebagai warning, lanjut tanpa crash
            Log::warning('GoogleSheetObserver: Sheets API error (sync skipped)', [
                'code'    => $e->getCode(),
                'message' => substr($e->getMessage(), 0, 300),
            ]);
        } catch (\Exception $e) {
            Log::warning('GoogleSheetObserver: Unexpected error during sync', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
