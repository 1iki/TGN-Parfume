<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\MongoDbSeeder;

class UserManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_admin_can_view_user_lists()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $response = $this->get('/Admin/users.php');
        $response->assertStatus(200);

        $legacyResponse1 = $this->get('/Admin/users-tabel-konsumen.php');
        $legacyResponse1->assertStatus(200);

        $legacyResponse2 = $this->get('/Admin/users-tabel-karyawan.php');
        $legacyResponse2->assertStatus(200);

        $legacyResponse3 = $this->get('/Admin/users-tabel-admin.php');
        $legacyResponse3->assertStatus(200);
    }

    public function test_admin_can_toggle_user_status()
    {
        $admin = User::where('username', 'admin')->first();
        $user = User::create([
            'username' => 'toggleuser',
            'fullname' => 'Toggle User',
            'email' => 'toggle@example.com',
            'phone' => '0812345678',
            'status' => 'Active',
            'password' => 'secret',
            'level' => 'consument',
        ]);

        $this->actingAs($admin);

        $response = $this->patch('/Admin/users/' . $user->_id . '/toggle');
        $response->assertRedirect();

        $updatedUser = User::find($user->_id);
        $this->assertEquals('Disabled', $updatedUser->status);

        // Toggle back
        $this->patch('/Admin/users/' . $user->_id . '/toggle');
        $updatedUser2 = User::find($user->_id);
        $this->assertEquals('Active', $updatedUser2->status);
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::where('username', 'admin')->first();
        $tempUser = User::create([
            'username' => 'tempuser',
            'email' => 'temp@gmail.com',
            'password' => '$2y$10$abcdefghijklmnopqrstuu',
            'level' => 'consument',
            'status' => 'Active',
        ]);

        $this->actingAs($admin);

        $response = $this->delete('/Admin/users/' . $tempUser->_id);
        $response->assertRedirect();

        $this->assertNull(User::find($tempUser->_id));
    }
}
