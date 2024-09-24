<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Profile;
use App\Models\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_comment()
    {
        // Create an administrator
        $administrator = Administrator::factory()->create([
            'password' => \Hash::make('password'),
        ]);

        // Create a profile
        $profile = Profile::factory()->create();

        // Create a comment request
        $response = $this->actingAs($administrator) // Authenticate as the administrator
            ->postJson('/api/profiles/'.$profile->id.'/comments', [
                'profile_id' => $profile->id,
                'content' => 'This is a test comment.',
            ]);

        // Assert that the comment was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', [
            'content' => 'This is a test comment.',
            'administrator_id' => $administrator->id,
            'profile_id' => $profile->id,
        ]);
        $this->assertEquals('created successfully !', $response->json('message'));
    }

    public function test_authenticated_user_cannot_create_duplicate_comment()
    {
        // Create an administrator
        $administrator = Administrator::factory()->create([
            'password' => \Hash::make('password'),
        ]);

        // Create a profile
        $profile = Profile::factory()->create();

        // Create an initial comment
        Comment::factory()->create([
            'administrator_id' => $administrator->id,
            'profile_id' => $profile->id,
        ]);

        // Attempt to create a duplicate comment
        $response = $this->actingAs($administrator) // Authenticate as the administrator
            ->postJson('/api/profiles/'.$profile->id.'/comments', [
                'profile_id' => $profile->id,
                'content' => 'This is a test comment.',
            ]);

        // Assert that the error response is received
        $response->assertStatus(400);
        $this->assertEquals('You have already commented on this profile', $response->json('message'));
    }

}
