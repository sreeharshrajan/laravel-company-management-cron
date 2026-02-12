<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserManagementSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_can_filter_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['name' => 'John Doe']);
        User::factory()->create(['name' => 'Jane Smith']);

        $response = $this->actingAs($admin)->get('/users?search=John');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    public function test_ajax_search_returns_partial_view()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['name' => 'John Doe']);

        $response = $this->actingAs($admin)->getJson('/users?search=John');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('<x-app-layout>', false); // Ensure full layout is not returned
    }
}
