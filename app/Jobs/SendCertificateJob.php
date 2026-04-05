<?php

namespace App\Jobs;

use App\Services\CertificateService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $batchId;

    /**
     * Create a new job instance.
     */
    public function __construct($id, $batchId = null)
    {
        $this->id = $id;
        $this->batchId = $batchId;
    }

    /**
     * Execute the job.
     */
    public function handle(CertificateService $service): void
    {
        try {
            Log::info("Processing SendCertificateJob for ID: {$this->id}, Batch: ".($this->batchId ?? 'none'));
            $service->sendEmail($this->id);
        } catch (\Exception $e) {
            Log::error("SendCertificateJob failed for ID {$this->id}: " . $e->getMessage());
        } finally {
            if ($this->batchId) {
                $key = "cert_batch_{$this->batchId}_current";
                $current = \Illuminate\Support\Facades\Cache::get($key, 0);
                \Illuminate\Support\Facades\Cache::put($key, (int)$current + 1, 3600);
                Log::info("Incremented Cache for Batch {$this->batchId} to: " . ($current + 1));
            }
        }
    }
}
