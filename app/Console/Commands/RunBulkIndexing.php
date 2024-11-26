<?php

namespace App\Console\Commands;

use App\Jobs\BulkUserIndexingJob;
use App\Jobs\IndexTasksJob;
use Illuminate\Console\Command;

class RunBulkIndexing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:bulk';

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
        $this->info('Dispatching BulkUserIndexingJob...');
        BulkUserIndexingJob::dispatch();
        $this->info('BulkUserIndexingJob dispatched.');

        $this->info('Dispatching IndexTasksJob...');
        IndexTasksJob::dispatch();
        $this->info('IndexTasksJob dispatched.');

        $this->info('All jobs dispatched successfully.');
    }
}
