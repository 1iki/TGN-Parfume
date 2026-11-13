<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Database\Seeders\MongoDbSeeder;

class LegacyParityMatrixTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_legacy_forgot_password_flow()
    {
        $user = User::create([
            'username' => 'resetuser',
            'fullname' => 'Reset Test User',
            'email' => 'resetuser@example.com',
            'phone' => '081298765432',
            'status' => 'Active',
            'password' => sha1('oldpass123'),
            'password_algorithm' => 'sha1',
            'level' => 'consument',
        ]);

        $response = $this->get('/forgot-password.php');
        $response->assertStatus(200);

        $response = $this->post('/forgot-password.php', [
            'fullname' => 'Reset Test User',
            'email' => 'resetuser@example.com',
            'phone' => '081298765432',
        ]);
        $response->assertRedirect('/reset-password.php');

        $response = $this->get('/reset-password.php');
        $response->assertStatus(200);

        $response = $this->post('/reset-password.php', [
            'new_pass' => 'newpassword123',
            'cpass' => 'newpassword123',
        ]);
        $response->assertRedirect('/login');

        // Verify login with new password
        $response = $this->post('/sign-in.php', [
            'username' => 'resetuser',
            'pass' => 'newpassword123',
        ]);
        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_legacy_users_profile_view_and_update()
    {
        $user = User::create([
            'username' => 'profileuser',
            'fullname' => 'Profile User',
            'email' => 'profileuser@example.com',
            'phone' => '0812345678',
            'status' => 'Active',
            'password' => 'secret',
            'level' => 'consument',
        ]);
        $this->actingAs($user);

        $response = $this->get('/users-profile.php');
        $response->assertStatus(200);
        $response->assertSee('My Profile');

        $response = $this->post('/users-profile.php', [
            'fullname' => 'Profile User Updated',
            'phone' => '081299999999',
            'address' => 'Jl. Jakarta Raya No. 12',
            'country' => 'Indonesia',
        ]);
        $response->assertStatus(302);

        $user->refresh();
        $this->assertEquals('Profile User Updated', $user->fullname);
        $this->assertEquals('081299999999', $user->phone);
    }

    public function test_legacy_product_detail_page_and_add_to_cart()
    {
        $product = Product::first();
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $response = $this->get('/product.php?pid=' . ($product->_id ?? $product->legacy_id));
        $response->assertStatus(200);
        $response->assertSee($product->name);

        $response = $this->post('/product.php', [
            'pid' => (string)($product->_id ?? $product->legacy_id),
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty' => 2,
            'add_to_cart' => '1',
        ]);
        $response->assertStatus(302);

        $cartItem = Cart::where('name', $product->name)->first();
        $this->assertNotNull($cartItem);
        $this->assertEquals(2, $cartItem->quantity);
    }

    public function test_legacy_checkout_form_submission()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $product = Product::first();
        Cart::create([
            'user_id' => $user->_id,
            'pid' => (string)$product->_id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image,
        ]);

        $response = $this->post('/checkout.php', [
            'firstname' => 'Krisna',
            'lastname' => 'Aprian',
            'email' => 'krisna@example.com',
            'number' => '0812345678',
            'address' => 'Jl. Buncit Raya No 10',
            'address2' => 'Apt 2B',
            'country' => 'Indonesia',
            'city' => 'Jakarta',
            'zip' => '12510',
            'method' => 'credit',
            'cc-name' => 'Krisna Aprian',
            'cc-number' => '1234567812345678',
            'cc-expiration' => '12/28',
            'cc-cvv' => '123',
            'total_products' => $product->name . ' (50000 x 1) - ',
            'total_price' => 50000,
            'order' => '1',
        ]);

        $response->assertRedirect('/orders');
        $order = Order::where('name', 'Krisna Aprian')->first();
        $this->assertNotNull($order);
        $this->assertEquals(50000, $order->total_price);
    }
}
