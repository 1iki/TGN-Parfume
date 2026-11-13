<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\MongoDbSeeder;

class AdminAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_unauthenticated_user_redirected_from_admin_dashboard()
    {
        $response = $this->get('/Admin');
        $response->assertRedirect('/login');
    }

    public function test_customer_user_denied_admin_access()
    {
        $customer = User::where('username', 'kriss')->first();
        $this->assertNotNull($customer);
        $this->actingAs($customer);

        $response = $this->get('/Admin');
        $response->assertRedirect('/');
    }

    public function test_admin_user_granted_access()
    {
        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);
        $this->actingAs($admin);

        $response = $this->get('/Admin');
        $response->assertStatus(200);
        $response->assertSee('Admin TGN');
    }
}
