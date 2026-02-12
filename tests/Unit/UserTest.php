<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_search_scope_filters_by_name()
    {
        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $results = User::filter(['search' => 'John'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals('John Doe', $results->first()->name);
    }

    public function test_user_search_scope_filters_by_email()
    {
        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $results = User::filter(['search' => 'jane@example.com'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Jane Smith', $results->first()->name);
    }

    public function test_user_filter_scope_filters_by_active_status()
    {
        User::factory()->create(['name' => 'Active User', 'last_active_at' => now()]);
        User::factory()->create(['name' => 'Inactive User', 'last_active_at' => now()->subDays(31)]);

        $results = User::filter(['status' => 'active'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Active User', $results->first()->name);
    }

    public function test_user_filter_scope_filters_by_inactive_status()
    {
        User::factory()->create(['name' => 'Active User', 'last_active_at' => now()]);
        User::factory()->create(['name' => 'Inactive User', 'last_active_at' => now()->subDays(31)]);
        User::factory()->create(['name' => 'Never Active User', 'last_active_at' => null]);

        $results = User::filter(['status' => 'inactive'])->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->contains('name', 'Inactive User'));
        $this->assertTrue($results->contains('name', 'Never Active User'));
    }
}
