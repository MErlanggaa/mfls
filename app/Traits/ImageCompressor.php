<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageCompressor
{
    /**
     * Compress an image to a specific quality and return the new path.
     * 
     * @param string $path Path relative to storage/app/public
     * @param int $quality Quality from 0 to 100
     * @param int|null $maxWidth Optional max width to resize
     * @return bool
     */
    public function compressImage($path, $quality = 60, $maxWidth = 1200)
    {
        // Jika GD extension tidak aktif, skip kompresi (file tetap tersimpan)
        if (!extension_loaded('gd')) {
            return true;
        }

        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            return false;
        }

        $info = getimagesize($fullPath);
        if (!$info)
            return false;

        $mime = $info['mime'];

        // Load image
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($fullPath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($fullPath);
                // Preserve transparency for PNG
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($fullPath);
                break;
            default:
                return false;
        }

        if (!$image)
            return false;

        // Resize if exceeds maxWidth
        $width = imagesx($image);
        $height = imagesy($image);

        if ($maxWidth && $width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));

            $tmpImg = imagecreatetruecolor($newWidth, $newHeight);

            if ($mime == 'image/png') {
                imagealphablending($tmpImg, false);
                imagesavealpha($tmpImg, true);
                $transparent = imagecolorallocatealpha($tmpImg, 255, 255, 255, 127);
                imagefilledrectangle($tmpImg, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($tmpImg, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $tmpImg;
        }

        // Save back with compression
        // Note: quality is handled differently for different formats in GD
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($image, $fullPath, $quality);
                break;
            case 'image/png':
                // PNG quality is 0-9 (0 = no compression, 9 = max compression)
                // We convert 0-100 quality to 0-9 compression (9 is best compression but slowest)
                $pngQuality = 9 - floor($quality / 11);
                imagepng($image, $fullPath, $pngQuality);
                break;
            case 'image/webp':
                imagewebp($image, $fullPath, $quality);
                break;
        }

        imagedestroy($image);
        return true;
    }
}
