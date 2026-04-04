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
            $service->sendEmail($this->id);
            
            if ($this->batchId) {
                \Illuminate\Support\Facades\Cache::increment("cert_batch_{$this->batchId}_current");
            }
        } catch (\Exception $e) {
            Log::error("SendCertificateJob failed for ID {$this->id}: " . $e->getMessage());
        }
    }
}
