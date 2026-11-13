<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Database\Seeders\MongoDbSeeder;
use Illuminate\Http\UploadedFile;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_product_catalog_displays_products()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Sauvage');
    }

    public function test_admin_can_create_product()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $file = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $response = $this->post('/Admin/penjualan-add-produk.php', [
            'name' => 'Parfume Test Unique',
            'details' => 'Fragrance description test',
            'price' => '250000',
            'categories' => 'male',
            'ingredient' => 'Citrus, Amber',
            'image' => $file,
        ]);

        $response->assertRedirect();

        $product = Product::where('name', 'Parfume Test Unique')->first();
        $this->assertNotNull($product);
        $this->assertEquals(250000, $product->price);
        $this->assertEquals('male', $product->categories);

        // Clean up test image
        if ($product->image && file_exists(public_path('uploaded_img/' . $product->image))) {
            @unlink(public_path('uploaded_img/' . $product->image));
        }
    }

    public function test_admin_can_update_product()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->put('/Admin/products/' . $product->_id, [
            'name' => $product->name . ' Updated',
            'details' => 'Updated details',
            'price' => '300000',
            'categories' => 'female',
            'ingredient' => 'Floral',
        ]);

        $response->assertRedirect();

        $updated = Product::find($product->_id);
        $this->assertEquals($product->name . ' Updated', $updated->name);
        $this->assertEquals(300000, $updated->price);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $product = Product::create([
            'name' => 'Product To Delete',
            'details' => 'Temp',
            'price' => 100000,
            'categories' => 'male',
            'image' => 'temp.jpg',
            'sold' => 0,
        ]);

        $response = $this->delete('/Admin/products/' . $product->_id);
        $response->assertRedirect();

        $this->assertNull(Product::find($product->_id));
    }
}
