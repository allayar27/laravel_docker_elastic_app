<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Elasticsearch;
use Illuminate\Support\Facades\Log;

class DeleteUsersIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("deleteting users index...");
        try {
            Elasticsearch::indices()->delete([
                'index' => 'users',
            ]);
        }
        catch (\Exception $e) {
            Log::error("Failed to delete index users: " . $e->getMessage());
        }
    }
}
