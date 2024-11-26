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


class IndexUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        info("Start indexing user with ID {$this->user->id}...");


        try {
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
                                ],
                                'email' => [
                                    'type' => 'text',
                                ],
                            ],
                        ]
                    ],
                ]);
                Log::info("Index 'users' created with mappings.");
            }

            Elasticsearch::index([
                'index' => 'users',
                'id' => $this->user->id,
                'body' => [
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
            ]);

            Log::info("User with ID {$this->user->id} was successfully indexed.");
            // $users = $this->user;
            // $bulkData = [];

            // foreach ($users as $user) {
            //     $bulkData['body'][] = [
            //         'index' => [
            //             '_index' => 'users',
            //             '_id' => $user->id,
            //         ]
            //     ];
            //     $bulkData['body'][] = [
            //         'name' => $user->name,
            //         'email' => $user->email,
            //     ];
            // }


            // if (!empty($bulkData)) {
            //     Elasticsearch::bulk($bulkData);
            //     Log::info("users were successfully indexed in bulk.");

            // } else {
            //     Log::info("no users to index");
            // }
        } catch (\Exception $e) {
            Log::error("Failed to index user with ID {$this->user->id}: " . $e->getMessage());
            // Log::error("failed to index users:" . $e->getMessage());
        }
    }
}
