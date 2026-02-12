<?php

namespace Tests\Feature;

use App\Jobs\PurgeInactiveUsersJob;
use App\Models\PurgeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PurgeInactiveUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_purge_inactive_users(): void
    {
        Bus::fake();

        // Active user (active 10 days ago)
        $activeUser = User::factory()->create([
            'last_active_at' => Carbon::now()->subDays(10),
        ]);

        // Inactive user (inactive 31 days ago)
        $inactiveUser = User::factory()->create([
            'last_active_at' => Carbon::now()->subDays(31),
        ]);

        $this->artisan('users:purge-inactive')
            ->expectsOutput('PurgeInactiveUsersJob dispatched successfully.')
            ->assertExitCode(0);

        Bus::assertDispatched(PurgeInactiveUsersJob::class);

        // Manually run the job to verify side effects
        (new PurgeInactiveUsersJob)->handle();

        $this->assertDatabaseHas('users', ['id' => $activeUser->id]);
        $this->assertDatabaseMissing('users', ['id' => $inactiveUser->id]);

        $this->assertDatabaseHas('purge_logs', [
            'users_count' => 1,
        ]);

        $log = PurgeLog::first();
        // Since we are mocking time or running in test, details might be checking against array of IDs
        // JSON encoding/decoding behavior might vary in tests, let's just check raw count or existence
        $this->assertNotNull($log);
        $this->assertTrue(in_array($inactiveUser->id, $log->details));
    }
}
