<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Database\Seeders\MongoDbSeeder;

class SecurityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_customer_cannot_access_admin_dashboard()
    {
        $customer = User::where('username', 'kriss')->first();
        $this->actingAs($customer);

        $response = $this->get('/Admin');
        $response->assertRedirect('/');
    }

    public function test_customer_cannot_delete_another_users_cart_item()
    {
        $user1 = User::where('username', 'kriss')->first();
        $user2 = User::where('username', 'gweh')->first();

        if (!$user2) {
            $user2 = User::create([
                'username' => 'gweh',
                'fullname' => 'Putra Ardiansyah',
                'email' => 'gweh@gmail.com',
                'password' => '12345678',
                'level' => 'consument',
                'status' => 'Active',
            ]);
        }

        $cart1 = Cart::create([
            'user_id' => $user1->_id,
            'pid' => '123456789012345678901234',
            'name' => 'Item User 1',
            'price' => 100000,
            'quantity' => 1,
            'image' => 'sample.jpg',
        ]);

        // Act as user2 trying to delete user1's cart item
        $this->actingAs($user2);

        $response = $this->delete('/cart/' . $cart1->_id);
        
        // Assert item belongs to user1 and remains intact
        $this->assertNotNull(Cart::find($cart1->_id));
    }

    public function test_malformed_objectid_handled_gracefully()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->get('/products/invalid-object-id-12345');
        $response->assertStatus(404);
    }

    public function test_customer_cannot_access_another_users_order()
    {
        $user1 = User::where('username', 'kriss')->first();
        $user2 = User::where('username', 'tes2')->first();

        $orderUser1 = Order::create([
            'user_id' => $user1->_id,
            'name' => 'Krisna Aprian',
            'number' => '08158061371',
            'email' => 'krisna@gmail.com',
            'method' => 'COD',
            'address' => 'Jl. Test No. 1',
            'total_products' => 'Parfume User 1 (1)',
            'total_price' => 100000,
            'placed_on' => date('d-M-Y'),
            'payment_status' => 'Pending',
        ]);

        // Act as user2 attempting to access user1's order details
        $this->actingAs($user2);
        $response = $this->get('/orders/' . $orderUser1->_id);
        $response->assertRedirect('/orders');
    }
}
