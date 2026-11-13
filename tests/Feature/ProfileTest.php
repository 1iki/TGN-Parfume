<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\MongoDbSeeder;
use Illuminate\Http\UploadedFile;

class ProfileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_authenticated_user_accessing_profile_redirects_or_renders()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $response = $this->get('/users-profile.php');
        $response->assertStatus(200);
    }

    public function test_customer_can_upload_replace_and_remove_profile_image()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        // 1. Upload initial profile image
        $image1 = UploadedFile::fake()->image('avatar1.jpg', 200, 200);
        $response = $this->post('/users-profile.php', [
            'fullname' => 'Krisna Updated',
            'profile_image' => $image1,
        ]);
        $response->assertStatus(302);

        $user->refresh();
        $this->assertNotNull($user->profile_image);
        $savedPath1 = public_path('uploaded_img/' . $user->profile_image);
        $this->assertFileExists($savedPath1);

        // 2. Replace with a second profile image
        $oldFile = $user->profile_image;
        $image2 = UploadedFile::fake()->image('avatar2.png', 200, 200);
        $response = $this->post('/users-profile.php', [
            'profile_image' => $image2,
        ]);
        $response->assertStatus(302);

        $user->refresh();
        $this->assertNotEquals($oldFile, $user->profile_image);
        $this->assertFileDoesNotExist(public_path('uploaded_img/' . $oldFile));
        $this->assertFileExists(public_path('uploaded_img/' . $user->profile_image));

        // 3. Remove profile image
        $fileToRemove = $user->profile_image;
        $response = $this->post('/users-profile.php', [
            'remove_image' => '1',
        ]);
        $response->assertStatus(302);

        $user->refresh();
        $this->assertNull($user->profile_image);
        $this->assertFileDoesNotExist(public_path('uploaded_img/' . $fileToRemove));
    }

    public function test_admin_can_access_and_update_admin_profile_with_image()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        // 1. Access admin profile page
        $response = $this->get('/Admin/users-profile.php');
        $response->assertStatus(200);
        $response->assertSee('Profil Administrator');

        // 2. Upload admin profile image
        $adminImage = UploadedFile::fake()->image('admin_avatar.webp', 200, 200);
        $response = $this->post('/Admin/users-profile.php', [
            'fullname' => 'Administrator TGN',
            'job' => 'Master Admin',
            'profile_image' => $adminImage,
        ]);
        $response->assertStatus(302);

        $admin->refresh();
        $this->assertEquals('Administrator TGN', $admin->fullname);
        $this->assertEquals('Master Admin', $admin->job);
        $this->assertNotNull($admin->profile_image);
        $this->assertFileExists(public_path('uploaded_img/' . $admin->profile_image));

        // Clean up uploaded file
        if ($admin->profile_image && file_exists(public_path('uploaded_img/' . $admin->profile_image))) {
            @unlink(public_path('uploaded_img/' . $admin->profile_image));
        }
    }

    public function test_customer_can_upload_gif_avatar_successfully()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $gifImage = UploadedFile::fake()->image('animated_avatar.gif', 150, 150);
        $response = $this->post('/users-profile.php', [
            'profile_image' => $gifImage,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertNotNull($user->profile_image);
        $this->assertStringEndsWith('.gif', $user->profile_image);
        $this->assertFileExists(public_path('uploaded_img/' . $user->profile_image));

        // Clean up
        if ($user->profile_image && file_exists(public_path('uploaded_img/' . $user->profile_image))) {
            @unlink(public_path('uploaded_img/' . $user->profile_image));
        }
    }

    public function test_customer_upload_fails_when_compressed_image_exceeds_3mb()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        // Mock ImageCompressionService to simulate compressed output exceeding 3MB
        $mockImageService = $this->createMock(\App\Services\ImageCompressionService::class);
        $mockImageService->method('compressAndSave')->willReturn([
            'success' => false,
            'filename' => null,
            'size' => 3500000,
            'error' => 'Ukuran file setelah kompresi (3.34 MB) melebihi batas maksimal 3MB. Upload gagal.',
        ]);
        $this->app->instance(\App\Services\ImageCompressionService::class, $mockImageService);

        $initialImage = $user->profile_image;
        $file = UploadedFile::fake()->image('huge.jpg', 200, 200);

        $response = $this->post('/users-profile.php', [
            'profile_image' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['profile_image']);

        $user->refresh();
        $this->assertEquals($initialImage, $user->profile_image);
    }

    public function test_admin_upload_fails_when_compressed_image_exceeds_3mb()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        // Mock ImageCompressionService to simulate compressed output exceeding 3MB
        $mockImageService = $this->createMock(\App\Services\ImageCompressionService::class);
        $mockImageService->method('compressAndSave')->willReturn([
            'success' => false,
            'filename' => null,
            'size' => 4194304,
            'error' => 'Ukuran file setelah kompresi (4.00 MB) melebihi batas maksimal 3MB. Upload gagal.',
        ]);
        $this->app->instance(\App\Services\ImageCompressionService::class, $mockImageService);

        $initialImage = $admin->profile_image;
        $file = UploadedFile::fake()->image('huge_admin.png', 200, 200);

        $response = $this->post('/Admin/users-profile.php', [
            'profile_image' => $file,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['profile_image']);

        $admin->refresh();
        $this->assertEquals($initialImage, $admin->profile_image);
    }
}
