<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class PdfAssetService
{
    public static function publicImagePath(string $relativePath, int $maxWidth = 480, int $quality = 72): string
    {
        return self::optimizedImagePath(public_path($relativePath), $maxWidth, $quality);
    }

    public static function publicStorageImagePath(?string $relativePath, int $maxWidth = 900, int $quality = 72): ?string
    {
        if (! $relativePath) {
            return null;
        }

        return self::optimizedImagePath(public_path('storage/'.$relativePath), $maxWidth, $quality);
    }

    public static function optimizedImagePath(string $sourcePath, int $maxWidth = 900, int $quality = 72): string
    {
        if (! extension_loaded('gd') || ! is_file($sourcePath)) {
            return $sourcePath;
        }

        $imageInfo = @getimagesize($sourcePath);

        if (! $imageInfo) {
            return $sourcePath;
        }

        [$width, $height, $type] = $imageInfo;

        if ($width <= 0 || $height <= 0) {
            return $sourcePath;
        }

        $extension = match ($type) {
            IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP => 'jpg',
            default => null,
        };

        if (! $extension) {
            return $sourcePath;
        }

        $cacheKey = md5($sourcePath.'|'.filemtime($sourcePath).'|'.filesize($sourcePath).'|'.$maxWidth.'|'.$quality);
        $cachePath = "generated/pdf-assets/{$cacheKey}.{$extension}";
        $disk = Storage::disk('local');

        if ($disk->exists($cachePath)) {
            return $disk->path($cachePath);
        }

        $source = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            default => false,
        };

        if (! $source) {
            return $sourcePath;
        }

        $targetWidth = min($width, $maxWidth);
        $targetHeight = (int) round(($height / $width) * $targetWidth);
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        $white = imagecolorallocate($target, 255, 255, 255);
        imagefill($target, 0, 0, $white);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $absoluteCachePath = $disk->path($cachePath);
        $directory = dirname($absoluteCachePath);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        imagejpeg($target, $absoluteCachePath, $quality);

        imagedestroy($source);
        imagedestroy($target);

        return $absoluteCachePath;
    }
}
