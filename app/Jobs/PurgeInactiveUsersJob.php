<?php

namespace App\Jobs;

use App\Models\PurgeLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PurgeInactiveUsersJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cutoffDate = Carbon::now()->subDays(30);

        $inactiveUsers = User::where('last_active_at', '<', $cutoffDate)->get();
        $count = $inactiveUsers->count();

        if ($count > 0) {
            User::where('last_active_at', '<', $cutoffDate)->delete();

            PurgeLog::create([
                'purged_at' => Carbon::now(),
                'users_count' => $count,
                'details' => $inactiveUsers->pluck('id')->toArray(),
            ]);
        }
    }
}
