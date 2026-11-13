<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Exception;

class ImageCompressionService
{
    /**
     * Maximum allowed size for the compressed image in bytes (3MB)
     */
    public const MAX_BYTES = 3 * 1024 * 1024; // 3,145,728 bytes

    /**
     * Compress and save an image or GIF without destroying pixel quality (preserving dimensions).
     * If the resulting compressed file is <= 3MB, it is saved successfully.
     * If the compressed result is > 3MB, the upload fails and any temporary file is removed.
     *
     * @param UploadedFile $file
     * @param string $destinationDir
     * @param string|null $customFilename
     * @return array ['success' => bool, 'filename' => ?string, 'size' => ?int, 'error' => ?string]
     */
    public function compressAndSave(UploadedFile $file, string $destinationDir, ?string $customFilename = null): array
    {
        if (!is_dir($destinationDir)) {
            @mkdir($destinationDir, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        // Generate target filename
        $filename = $customFilename ?: 'img_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $targetPath = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

        $mime = $file->getMimeType();
        $sourcePath = $file->getRealPath();

        try {
            switch ($extension) {
                case 'gif':
                    $this->compressGif($sourcePath, $targetPath);
                    break;

                case 'png':
                    $this->compressPng($sourcePath, $targetPath);
                    break;

                case 'jpg':
                    $this->compressJpg($sourcePath, $targetPath);
                    break;

                case 'webp':
                    $this->compressWebp($sourcePath, $targetPath);
                    break;

                default:
                    // Fallback for any other valid image format
                    @copy($sourcePath, $targetPath);
                    break;
            }
        } catch (Exception $e) {
            // If processing encountered an error, attempt safe direct copy as fallback
            if (!file_exists($targetPath)) {
                @copy($sourcePath, $targetPath);
            }
        }

        if (!file_exists($targetPath)) {
            return [
                'success' => false,
                'filename' => null,
                'size' => 0,
                'error' => 'Gagal memproses dan menyimpan file gambar.',
            ];
        }

        $finalSize = filesize($targetPath);

        // Strict limit check: must not exceed 3MB
        if ($finalSize > self::MAX_BYTES) {
            @unlink($targetPath);
            $sizeFormatted = round($finalSize / (1024 * 1024), 2);
            return [
                'success' => false,
                'filename' => null,
                'size' => $finalSize,
                'error' => "Ukuran file setelah kompresi ({$sizeFormatted} MB) melebihi batas maksimal 3MB. Upload gagal.",
            ];
        }

        return [
            'success' => true,
            'filename' => $filename,
            'size' => $finalSize,
            'error' => null,
        ];
    }

    /**
     * Compress PNG using lossless zlib compression level 9 (preserves 100% pixel data & alpha channel).
     */
    protected function compressPng(string $sourcePath, string $targetPath): void
    {
        $image = @imagecreatefrompng($sourcePath);
        if (!$image) {
            @copy($sourcePath, $targetPath);
            return;
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);

        // Quality level 9 = maximum lossless compression
        imagepng($image, $targetPath, 9);
        imagedestroy($image);
    }

    /**
     * Compress JPG preserving pixel dimensions and high visual quality (85-92%).
     */
    protected function compressJpg(string $sourcePath, string $targetPath): void
    {
        $image = @imagecreatefromjpeg($sourcePath);
        if (!$image) {
            @copy($sourcePath, $targetPath);
            return;
        }

        // First pass at 90% quality for optimal pixel sharpness
        imagejpeg($image, $targetPath, 90);

        // If file exceeds 3MB, optimize quality down to 82% to fit without noticeable degradation
        if (file_exists($targetPath) && filesize($targetPath) > self::MAX_BYTES) {
            imagejpeg($image, $targetPath, 82);
        }

        imagedestroy($image);
    }

    /**
     * Compress WebP preserving pixel dimensions and alpha channel.
     */
    protected function compressWebp(string $sourcePath, string $targetPath): void
    {
        $image = @imagecreatefromwebp($sourcePath);
        if (!$image) {
            @copy($sourcePath, $targetPath);
            return;
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);

        imagewebp($image, $targetPath, 88);
        imagedestroy($image);
    }

    /**
     * Compress or preserve GIF (keeps animation frames if file is already <= 3MB, or compresses static GIF).
     */
    protected function compressGif(string $sourcePath, string $targetPath): void
    {
        $originalSize = filesize($sourcePath);

        // If original GIF is already within 3MB, preserve all frames and palette intact
        if ($originalSize <= self::MAX_BYTES) {
            @copy($sourcePath, $targetPath);
            return;
        }

        // If over 3MB, attempt palette/frame compression via GD
        $image = @imagecreatefromgif($sourcePath);
        if ($image) {
            imagegif($image, $targetPath);
            imagedestroy($image);
        } else {
            @copy($sourcePath, $targetPath);
        }
    }
}

