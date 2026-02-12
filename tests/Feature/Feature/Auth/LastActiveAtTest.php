<?php

namespace Tests\Feature\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LastActiveAtTest extends TestCase
{
    /**
     * Test that user's last_active_at is updated on login.
     */
    public function test_last_active_at_is_updated_on_login(): void
    {
        $user = \App\Models\User::factory()->create([
            'last_active_at' => now()->subDays(5),
        ]);
        
        $oldTimestamp = $user->last_active_at;

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        
        $user->refresh();
        
        $this->assertNotEquals($oldTimestamp->toDateTimeString(), $user->last_active_at->toDateTimeString());
        $this->assertTrue($user->last_active_at->gt($oldTimestamp));
    }
}
