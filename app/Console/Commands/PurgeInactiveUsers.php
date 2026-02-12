<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurgeInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:purge-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge users inactive for more than 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = \Carbon\Carbon::now()->subDays(30);

        $inactiveUsers = \App\Models\User::where('last_active_at', '<', $cutoffDate)->get();
        $count = $inactiveUsers->count();

        if ($count > 0) {
            \App\Models\User::where('last_active_at', '<', $cutoffDate)->delete();

            \App\Models\PurgeLog::create([
                'purged_at' => \Carbon\Carbon::now(),
                'users_count' => $count,
                'details' => $inactiveUsers->pluck('id')->toArray(),
            ]);

            $this->info("Purged {$count} inactive users.");
        } else {
            $this->info('No inactive users found.');
        }
    }
}
