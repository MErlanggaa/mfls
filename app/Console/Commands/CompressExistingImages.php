<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageCompressor;

class CompressExistingImages extends Command
{
    use ImageCompressor;

    protected $signature = 'images:compress {--quality=60} {--width=1200}';
    protected $description = 'Compress all existing uploaded images in storage/app/public';

    public function handle()
    {
        $quality = $this->option('quality');
        $width = $this->option('width');
        
        $this->info("Starting image compression (Quality: $quality)...");

        $files = Storage::disk('public')->allFiles();
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        $count = 0;
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            if (in_array($ext, $imageExtensions)) {
                $this->line("Compressing: $file");
                if ($this->compressImage($file, $quality, $width)) {
                    $count++;
                }
            }
        }

        $this->info("Successfully compressed $count images.");
    }
}
