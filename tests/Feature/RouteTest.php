<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Database\Seeders\MongoDbSeeder;

class RouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_home_page_and_legacy_index_url_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $legacyResponse = $this->get('/index.php');
        $legacyResponse->assertStatus(200);
    }

    public function test_about_page_accessible()
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    public function test_contact_page_accessible()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
    }

    public function test_products_catalog_page_and_legacy_url_accessible()
    {
        $response = $this->get('/products');
        $response->assertStatus(200);

        $legacyResponse = $this->get('/product.php');
        $legacyResponse->assertStatus(200);
    }

    public function test_product_detail_page_loads_correct_product()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->get('/products/' . $product->_id);
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_search_endpoint_returns_matching_products()
    {
        $response = $this->get('/search?search=Blue');
        $response->assertStatus(200);
        $response->assertSee('Blue Seduction');
    }
}
