<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Database\Seeders\MongoDbSeeder;

class CheckoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_checkout_creates_order_increments_sold_and_clears_cart()
    {
        $user = User::where('username', 'kriss')->first();
        $product = Product::first();
        $this->assertNotNull($user);
        $this->assertNotNull($product);

        $initialSold = $product->sold ?? 0;

        $this->actingAs($user);

        // Add item to cart
        Cart::create([
            'user_id' => $user->_id,
            'pid' => (string)$product->_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 2,
            'image' => $product->image,
        ]);

        $response = $this->post('/checkout', [
            'name' => 'Krisna Aprian',
            'number' => '08158061371',
            'email' => 'krisnawirawan57@gmail.com',
            'method' => 'Cash on Delivery (COD)',
            'flat' => 'No. 12',
            'street' => 'Jl. Kemang',
            'city' => 'Jakarta Selatan',
            'state' => 'DKI Jakarta',
            'country' => 'Indonesia',
            'pin_code' => '12510',
        ]);

        $response->assertRedirect('/orders');

        // Assert order record was created
        $order = Order::where('user_id', $user->_id)->latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('Krisna Aprian', $order->name);
        $this->assertEquals('Pending', $order->payment_status);

        // Assert product sold counter was incremented by 2
        $updatedProduct = Product::find($product->_id);
        $this->assertEquals($initialSold + 2, $updatedProduct->sold);

        // Assert cart was cleared for user
        $this->assertEquals(0, Cart::where('user_id', $user->_id)->count());
    }
}
