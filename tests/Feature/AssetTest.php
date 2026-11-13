<?php

namespace Tests\Feature;

use Tests\TestCase;

class AssetTest extends TestCase
{
    public function test_storefront_assets_exist()
    {
        $this->assertFileExists(public_path('assets/css/main.css'));
    }

    public function test_admin_assets_exist()
    {
        $this->assertFileExists(public_path('Admin/assets/css/style.css'));
        $this->assertFileExists(public_path('Admin/assets/js/main.js'));
        $this->assertFileExists(public_path('Admin/assets/vendor/bootstrap/css/bootstrap.min.css'));
    }

    public function test_images_directory_exists()
    {
        $this->assertDirectoryExists(public_path('images'));
        $this->assertDirectoryExists(public_path('uploaded_img'));
    }
}
