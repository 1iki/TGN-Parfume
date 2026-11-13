<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Database\Seeders\MongoDbSeeder;

class CartTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
        Cart::truncate();
    }

    public function test_user_can_add_product_to_cart()
    {
        $user = User::where('username', 'kriss')->first();
        $product = Product::first();
        $this->assertNotNull($user);
        $this->assertNotNull($product);

        $this->actingAs($user);

        $response = $this->post('/cart/add', [
            'product_id' => $product->_id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();

        $cartItem = Cart::where('user_id', $user->_id)->where('pid', (string)$product->_id)->first();
        $this->assertNotNull($cartItem);
        $this->assertEquals(2, $cartItem->quantity);
    }

    public function test_adding_duplicate_product_increments_quantity()
    {
        $user = User::where('username', 'kriss')->first();
        $product = Product::first();
        $this->assertNotNull($user);
        $this->assertNotNull($product);

        $this->actingAs($user);

        $this->post('/cart/add', [
            'product_id' => $product->_id,
            'quantity' => 1,
        ]);

        $this->post('/cart/add', [
            'product_id' => $product->_id,
            'quantity' => 3,
        ]);

        $cartItem = Cart::where('user_id', $user->_id)->where('pid', (string)$product->_id)->first();
        $this->assertEquals(4, $cartItem->quantity);
    }

    public function test_user_can_clear_cart()
    {
        $user = User::where('username', 'kriss')->first();
        $product = Product::first();
        $this->assertNotNull($user);

        $this->actingAs($user);

        $this->post('/cart/add', [
            'product_id' => $product->_id,
            'quantity' => 1,
        ]);

        $response = $this->delete('/cart/clear');
        $response->assertRedirect();

        $this->assertEquals(0, Cart::where('user_id', $user->_id)->count());
    }

    public function test_legacy_delete_all_query_param_clears_cart()
    {
        $user = User::where('username', 'kriss')->first();
        $product = Product::first();

        $this->actingAs($user);

        $this->post('/cart/add', [
            'product_id' => $product->_id,
            'quantity' => 1,
        ]);

        $response = $this->get('/cart.php?delete_all=1');
        $response->assertRedirect();

        $this->assertEquals(0, Cart::where('user_id', $user->_id)->count());
    }
}
