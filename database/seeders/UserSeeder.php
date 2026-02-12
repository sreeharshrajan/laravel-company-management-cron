<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'last_active_at' => now(),
        ]);

        // Regular User
        User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Regular User',
            'password' => Hash::make('password'),
            'role' => 'user',
            'last_active_at' => now(),
        ]);

        // Create 10 Active Users
        User::factory()->count(10)->create();

        // Create 5 Inactive Users (for testing Purge)
        User::factory()->count(5)->inactive()->create();
    }
}
