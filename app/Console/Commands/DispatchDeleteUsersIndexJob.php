<?php

namespace App\Console\Commands;

use App\Jobs\DeleteUsersIndexJob;
use Illuminate\Console\Command;

class DispatchDeleteUsersIndexJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:delete-users-index-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DeleteUsersIndexJob::dispatch();
        $this->info("DeleteUsersIndexJob has been dispatched.");
    }
}
