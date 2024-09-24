<?php

namespace Tests\Feature\Auth;

use App\Models\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_credentials()
    {
        $administrator = Administrator::factory()->create([
            'password' => \Hash::make('password'), // Make sure the password is hashed
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $administrator->email,
            'password' => 'password',
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure(['token']); // Assuming your API returns a token
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($administrator);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $administrator = Administrator::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $administrator->email,
            'password' => 'invalid-password',
        ]);

        $response->assertUnauthorized();
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid credentials']);
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_nonexistent_email()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $response->assertUnauthorized();
        $response->assertJson(['message' => 'Invalid credentials']); // Adjust according to your API response
        $this->assertGuest();
    }
}
