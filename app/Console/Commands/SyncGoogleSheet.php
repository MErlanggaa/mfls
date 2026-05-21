<?php

namespace App\Console\Commands;

use App\Services\GoogleSheetService;
use Illuminate\Console\Command;

class SyncGoogleSheet extends Command
{
    protected $signature = 'gsheet:sync';
    protected $description = 'Manually sync all pendaftar data to Google Sheets';

    public function handle(GoogleSheetService $service)
    {
        $this->info('Starting Google Sheet sync...');
        $this->info('Spreadsheet ID: ' . config('services.google_sheet.id', 'NOT SET'));

        try {
            $service->syncAll();
            $this->info('✅ Google Sheet sync completed successfully!');
        } catch (\Exception $e) {
            $this->error('❌ Sync failed: ' . $e->getMessage());
            $this->error('Code: ' . $e->getCode());
            return 1;
        }

        return 0;
    }
}
