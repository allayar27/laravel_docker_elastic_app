<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Elasticsearch;
use Illuminate\Support\Facades\Log;

class BulkUserIndexingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info("start indexing all users...");

        if (!Elasticsearch::indices()->exists(["index" => "users"])) {
            Elasticsearch::indices()->create([
                "index" => "users",
                "body" => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 1,
                    ],
                    'mappings' => [
                        'properties' => [
                            'name' => [
                                'type' => 'text',
                                'copy_to' => 'combined_fields',
                            ],
                            'email' => [
                                'type' => 'text',
                                'copy_to' => 'combined_fields',
                            ],
                            'combined_fields' => [
                                'type' => 'text',
                            ],
                            //],
                        ],
                    ],
                ],
            ]);
            Log::info("Index 'users' created with mappings.");
        }

        $users = User::all();
        $bulkData = [];

        foreach ($users as $user) {
            $bulkData['body'][] = [
                'index' => [
                    '_index' => 'users',
                    '_id' => $user->id,
                ]
            ];
            $bulkData['body'][] = [
                'name' => $user->name,
                'email' => $user->email,
            ];
        }

        try {
            if (!empty($bulkData)) {
                Elasticsearch::bulk($bulkData);
                Log::info("users were successfully indexed in bulk.");

            } else {
                Log::info("no users to index");
            }
        } catch (\Exception $e) {
            Log::error("failed to index users:" . $e->getMessage());
        }
    }
}
