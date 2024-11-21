<?php

namespace App\Console\Commands;

use App\Jobs\IndexTasksJob;
use Illuminate\Console\Command;

class DispatchIndexTasksJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:index-tasks-job';

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
        IndexTasksJob::dispatch();
        $this->info("IndexTasksJob has been dispatched.");
    }
}
