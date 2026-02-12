<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurgeInactiveUsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_purge_inactive_users(): void
    {
        // Active user (active 10 days ago)
        $activeUser = \App\Models\User::factory()->create([
            'last_active_at' => \Carbon\Carbon::now()->subDays(10),
        ]);

        // Inactive user (inactive 31 days ago)
        $inactiveUser = \App\Models\User::factory()->create([
            'last_active_at' => \Carbon\Carbon::now()->subDays(31),
        ]);

        $this->artisan('users:purge-inactive')
            ->expectsOutput('Purged 1 inactive users.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', ['id' => $activeUser->id]);
        $this->assertDatabaseMissing('users', ['id' => $inactiveUser->id]);

        $this->assertDatabaseHas('purge_logs', [
            'users_count' => 1,
        ]);

        $log = \App\Models\PurgeLog::first();
        $this->assertContains($inactiveUser->id, $log->details);
    }
}
