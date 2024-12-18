<?php

namespace App\Console\Commands;

use App\Jobs\BulkUserIndexingJob;
use App\Jobs\IndexUsersJob;
use Illuminate\Console\Command;

class DispatchIndexUsersJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:index-users-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        BulkUserIndexingJob::dispatch();
        $this->info("BulkUserIndexingJob has been dispatched.");
    }
}
