<?php

namespace App\Console\Commands;

use App\Models\Akun;
use App\Services\CertificateService;
use Illuminate\Console\Command;

class SendBulkCertificates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificates:send-bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send certificates to all registered pendaftars';

    /**
     * Execute the console command.
     */
    public function handle(CertificateService $service)
    {
        $pendaftars = Akun::where('role', 'pendaftar')
            ->where('is_sertifikat_sent', false)
            ->whereNull('deleted_at') // Only active users
            ->get();

        if ($pendaftars->isEmpty()) {
            $this->info('No pendaftars found.');
            return;
        }

        $this->info('Sending certificates to ' . $pendaftars->count() . ' pendaftars...');

        $bar = $this->output->createProgressBar($pendaftars->count());
        $bar->start();

        foreach ($pendaftars as $user) {
            $service->sendEmail($user->id);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All certificates sent successfully!');
    }
}
