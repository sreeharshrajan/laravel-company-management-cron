<?php

namespace App\Console\Commands;

use App\Jobs\PurgeInactiveUsersJob;
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
        PurgeInactiveUsersJob::dispatch();
        $this->info('PurgeInactiveUsersJob dispatched successfully.');
    }
}
