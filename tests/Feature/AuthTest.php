<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\MongoDbSeeder;

class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_login_page_renders_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $legacyResponse = $this->get('/sign-in.php');
        $legacyResponse->assertStatus(200);
    }

    public function test_invalid_login_credentials_rejected()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
    }

    public function test_sha1_password_auto_upgrades_to_bcrypt_on_login()
    {
        $user = User::create([
            'username' => 'sha1user',
            'fullname' => 'SHA1 Test User',
            'email' => 'sha1user@example.com',
            'phone' => '08123456789',
            'status' => 'Active',
            'password' => sha1('secret123'),
            'password_algorithm' => 'sha1',
            'level' => 'consument',
        ]);

        $response = $this->post('/login', [
            'email' => 'sha1user@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Auth::check());

        $updatedUser = User::find($user->_id);
        $this->assertEquals('bcrypt', $updatedUser->password_algorithm);
        $this->assertTrue(Hash::check('secret123', $updatedUser->password));
    }

    public function test_disabled_account_cannot_login()
    {
        $user = User::where('username', 'tes3')->first(); // status Disabled
        $this->assertNotNull($user);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
    }

    public function test_logout_invalidates_session()
    {
        $user = User::where('username', 'kriss')->first();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect();
        $this->assertFalse(Auth::check());
    }
}
