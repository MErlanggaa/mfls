<?php

namespace App\Jobs;

use App\Services\GoogleSheetService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncGoogleSheetJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 180;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the unique job lock should be held.
     *
     * @var int
     */
    public $uniqueFor = 300;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(GoogleSheetService $service): void
    {
        try {
            $service->syncAll();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            
            // Check for Google Sheets API rate limit (429) or service unavailable (503)
            if ($code === 429 || $code === 503 || 
                str_contains(strtolower($message), '503') || 
                str_contains(strtolower($message), 'unavailable') || 
                str_contains(strtolower($message), '429') || 
                str_contains(strtolower($message), 'rate limit') ||
                str_contains(strtolower($message), 'too many requests')
            ) {
                Log::warning('SyncGoogleSheetJob encountered a temporary Google API error. Releasing job back to queue in 120s: ' . $message);
                $this->release(120);
                return;
            }

            Log::error('SyncGoogleSheetJob failed with fatal error: ' . $message);
            throw $e;
        }
    }
}
