<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_list_users(): void
    {
        $user = User::factory()->create();
        User::factory(3)->create();

        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(4);
    }

    public function test_can_create_user(): void
    {
        $user = User::factory()->create();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ];

        $response = $this->actingAs($user)->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John Doe', 'email' => 'john@example.com']);
        
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_can_show_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->getJson("/api/users/{$otherUser->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $otherUser->id, 'email' => $otherUser->email]);
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();
        $updateData = ['name' => 'Updated Name'];

        $response = $this->actingAs($user)->putJson("/api/users/{$targetUser->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);
        
        $this->assertDatabaseHas('users', ['id' => $targetUser->id, 'name' => 'Updated Name']);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/users/{$targetUser->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_validation_errors(): void
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->postJson('/api/users', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
            
        $response = $this->actingAs($user)->postJson('/api/users', [
            'name' => 'Test',
            'email' => $user->email, // Duplicate email
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
