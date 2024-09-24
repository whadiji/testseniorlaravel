<?php

namespace Tests\Feature;

use App\Models\Administrator;
use App\Models\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_administrator_can_create_a_profile(): void
    {
        $administrator = Administrator::factory()->create([
            'password' => \Hash::make('password'),
        ]);
        $profile = Profile::factory([
            'administrator_id' => $administrator->id
        ])->make();
        $file = UploadedFile::fake()->image($profile->image);
        $response = $this->withHeader('Authorization', 'Bearer ' . $administrator->createToken('AdminToken')->plainTextToken)
            ->postJson('/api/profiles', [
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'status' => $profile->status,
                'image' => $file,
            ]);
        $response->assertStatus(201);
    }

    public function test_an_authenticated_administrator_can_update_profile(): void
    {
                // Création d'un administrateur et d'un profil associé
        $administrator = Administrator::factory()->create([
            'password' => \Hash::make('password'),
        ]);

        $profile = Profile::factory([
            'administrator_id' => $administrator->id,
            'status' => 'inactive'
        ])->create();

        $updateResponse = $this->withHeader('Authorization', 'Bearer ' . $administrator->createToken('AdminToken')->plainTextToken)
            ->postJson('/api/profiles/' . $profile->id, [
                'first_name' => 'Updated first_name',
                'last_name' => 'Updated last_name',
                'status' => 'active',
                'action' => 'update',
            ]);

        $updatedProfile = Profile::find($profile->id);

        $this->assertNotEmpty($updatedProfile);
        $this->assertEquals('Updated first_name', $updatedProfile->first_name);
        $this->assertEquals('Updated last_name', $updatedProfile->last_name);
        $this->assertEquals('active', $updatedProfile->status);
        $updateResponse->assertStatus(200);
    }
    public function test_an_authenticated_administrator_can_delete_profile(): void
    {
            // Create an administrator
            $administrator = Administrator::factory()->create([
                'password' => \Hash::make('password'),
            ]);

        // Create a profile associated with the administrator
        $profile = Profile::factory()->create([
            'administrator_id' => $administrator->id,
        ]);

        // Send a request to delete the profile
        $deleteResponse = $this->withHeader('Authorization', 'Bearer ' . $administrator->createToken('AdminToken')->plainTextToken)
            ->postJson('/api/profiles/' . $profile->id, [
                'action' => 'delete', // Indicate that the action is to delete
            ]);

        // Verify the response status
        $deleteResponse->assertStatus(200);

        // Check that the profile has been deleted
        $deletedProfile = Profile::find($profile->id);
        $this->assertNull($deletedProfile, 'The profile should have been deleted but it still exists.');
    }
}
