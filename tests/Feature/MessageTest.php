<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Database\Seeders\MongoDbSeeder;

class MessageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MongoDbSeeder::class);
    }

    public function test_user_can_submit_contact_message()
    {
        $response = $this->post('/contact', [
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'number' => '08123456789',
            'message' => 'Halo, produk ini sangat harum dan tahan lama.',
        ]);

        $response->assertRedirect();

        $message = Message::where('email', 'budi@gmail.com')->first();
        $this->assertNotNull($message);
        $this->assertEquals('Halo, produk ini sangat harum dan tahan lama.', $message->message);
    }

    public function test_admin_can_view_and_delete_messages()
    {
        $admin = User::where('username', 'admin')->first();
        $this->actingAs($admin);

        $message = Message::create([
            'user_id' => null,
            'name' => 'Test Sender',
            'email' => 'test@gmail.com',
            'number' => '089999999',
            'message' => 'Pesan pengujian',
        ]);

        $indexResponse = $this->get('/Admin/messages');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Pesan pengujian');

        $deleteResponse = $this->delete('/Admin/messages/' . $message->_id);
        $deleteResponse->assertRedirect();

        $this->assertNull(Message::find($message->_id));
    }
}
