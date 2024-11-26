<?php

namespace App\Console\Commands;

use App\Jobs\DeleteTasksIndexJob;
use Illuminate\Console\Command;

class DispatchDeleteTasksIndexJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:delete-tasks-index-job';

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
        DeleteTasksIndexJob::dispatch();
        $this->info("DeleteTasksIndexJob has been dispatched.");
    }
}
