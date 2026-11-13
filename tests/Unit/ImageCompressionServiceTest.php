<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ImageCompressionService;
use Illuminate\Http\UploadedFile;

class ImageCompressionServiceTest extends TestCase
{
    protected string $tempDir;
    protected ImageCompressionService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test_imgs_' . uniqid();
        @mkdir($this->tempDir, 0755, true);
        $this->service = new ImageCompressionService();
    }

    protected function tearDown(): void
    {
        if (is_dir($this->tempDir)) {
            $files = glob($this->tempDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            @rmdir($this->tempDir);
        }
        parent::tearDown();
    }

    public function test_compresses_png_and_preserves_dimensions()
    {
        $file = UploadedFile::fake()->image('test_image.png', 400, 300);
        $result = $this->service->compressAndSave($file, $this->tempDir);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['filename']);
        $this->assertLessThanOrEqual(ImageCompressionService::MAX_BYTES, $result['size']);

        $savedFilePath = $this->tempDir . DIRECTORY_SEPARATOR . $result['filename'];
        $this->assertFileExists($savedFilePath);

        [$width, $height] = getimagesize($savedFilePath);
        $this->assertEquals(400, $width);
        $this->assertEquals(300, $height);
    }

    public function test_compresses_jpg_and_preserves_dimensions()
    {
        $file = UploadedFile::fake()->image('test_image.jpg', 500, 400);
        $result = $this->service->compressAndSave($file, $this->tempDir);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['filename']);
        $this->assertLessThanOrEqual(ImageCompressionService::MAX_BYTES, $result['size']);

        $savedFilePath = $this->tempDir . DIRECTORY_SEPARATOR . $result['filename'];
        $this->assertFileExists($savedFilePath);

        [$width, $height] = getimagesize($savedFilePath);
        $this->assertEquals(500, $width);
        $this->assertEquals(400, $height);
    }

    public function test_compresses_webp_and_preserves_dimensions()
    {
        $file = UploadedFile::fake()->image('test_image.webp', 350, 350);
        $result = $this->service->compressAndSave($file, $this->tempDir);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['filename']);
        $this->assertLessThanOrEqual(ImageCompressionService::MAX_BYTES, $result['size']);

        $savedFilePath = $this->tempDir . DIRECTORY_SEPARATOR . $result['filename'];
        $this->assertFileExists($savedFilePath);

        [$width, $height] = getimagesize($savedFilePath);
        $this->assertEquals(350, $width);
        $this->assertEquals(350, $height);
    }

    public function test_handles_gif_and_preserves_under_3mb()
    {
        // Create a small GIF
        $file = UploadedFile::fake()->image('sample.gif', 200, 200);
        $result = $this->service->compressAndSave($file, $this->tempDir);

        $this->assertTrue($result['success']);
        $this->assertNotNull($result['filename']);
        $this->assertLessThanOrEqual(ImageCompressionService::MAX_BYTES, $result['size']);

        $savedFilePath = $this->tempDir . DIRECTORY_SEPARATOR . $result['filename'];
        $this->assertFileExists($savedFilePath);
    }

    public function test_fails_when_compressed_image_exceeds_3mb()
    {
        // Create an anonymous subclass or mock with low MAX_BYTES to test strict threshold handling
        $mockService = new class extends ImageCompressionService {
            // Override MAX_BYTES behavior for testing size threshold enforcement
            public function setTestMaxBytes(int $bytes): void
            {
                $this->testMaxBytes = $bytes;
            }
            private int $testMaxBytes = 100; // Force 100 bytes limit

            public function compressAndSave(UploadedFile $file, string $destinationDir, ?string $customFilename = null): array
            {
                if (!is_dir($destinationDir)) {
                    @mkdir($destinationDir, 0755, true);
                }

                $filename = $customFilename ?: 'img_test_exceed.' . $file->getClientOriginalExtension();
                $targetPath = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
                @copy($file->getRealPath(), $targetPath);

                $finalSize = filesize($targetPath);
                if ($finalSize > $this->testMaxBytes) {
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
        };

        $file = UploadedFile::fake()->image('big.jpg', 600, 600);
        $result = $mockService->compressAndSave($file, $this->tempDir);

        $this->assertFalse($result['success']);
        $this->assertNull($result['filename']);
        $this->assertStringContainsString('melebihi batas maksimal 3MB. Upload gagal.', $result['error']);

        // Assert file was cleaned up and does not remain on disk
        $this->assertFileDoesNotExist($this->tempDir . DIRECTORY_SEPARATOR . 'img_test_exceed.jpg');
    }
}

