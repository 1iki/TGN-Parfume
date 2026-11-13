<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Database\Seeders\MongoDbSeeder;

class OrderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_customer_can_view_own_orders()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $response = $this->get('/orders');
        $response->assertStatus(200);

        $legacyResponse = $this->get('/purchase-history.php');
        $legacyResponse->assertStatus(200);
    }

    public function test_admin_can_view_all_orders()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->get('/Admin/penjualan-history-pesanan.php');
        $response->assertStatus(200);
    }

    public function test_admin_can_update_order_payment_status()
    {
        $admin = User::where('username', 'admin')->first();
        $user = User::where('username', 'kriss')->first();

        $order = Order::create([
            'user_id' => $user->_id,
            'name' => 'Krisna Aprian',
            'number' => '08158061371',
            'email' => 'krisna@gmail.com',
            'method' => 'COD',
            'address' => 'Jl. Test No. 1',
            'total_products' => 'Parfume A (1)',
            'total_price' => 150000,
            'placed_on' => date('d-M-Y'),
            'payment_status' => 'Pending',
        ]);

        $this->actingAs($admin);

        $response = $this->put('/Admin/orders/' . $order->_id . '/status', [
            'payment_status' => 'Completed',
        ]);

        $response->assertRedirect();

        $updatedOrder = Order::find($order->_id);
        $this->assertEquals('Completed', $updatedOrder->payment_status);
    }

    public function test_admin_can_delete_order()
    {
        $admin = User::where('username', 'admin')->first();
        $user = User::where('username', 'kriss')->first();

        $order = Order::create([
            'user_id' => $user->_id,
            'name' => 'Krisna Aprian',
            'number' => '08158061371',
            'email' => 'krisna@gmail.com',
            'method' => 'COD',
            'address' => 'Jl. Test No. 1',
            'total_products' => 'Parfume B (1)',
            'total_price' => 200000,
            'placed_on' => date('d-M-Y'),
            'payment_status' => 'Pending',
        ]);

        $this->actingAs($admin);

        $response = $this->delete('/Admin/orders/' . $order->_id);
        $response->assertRedirect();

        $this->assertNull(Order::find($order->_id));
    }
}
