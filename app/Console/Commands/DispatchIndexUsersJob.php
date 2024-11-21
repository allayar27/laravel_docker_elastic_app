<?php

namespace App\Console\Commands;

use App\Jobs\IndexUsersJob;
use App\Models\User;
use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;
use Elasticsearch;
use Illuminate\Support\Facades\Log;

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
    // public function handle()
    // {
    //     IndexUsersJob::dispatch();
    //     $this->info("IndexUsersJob has been dispatched.");
    // }

    public function handle(): void
    {
        // try {
        //     $ping = Elasticsearch::ping();
        //     if ($ping) {
        //         $this->info('Elasticsearch is reachable.');
        //     } else {
        //         $this->error('Elasticsearch is not reachable.');
        //     }
        // } catch (\Exception $e) {
        //     $this->error('Error connecting to Elasticsearch: ' . $e->getMessage());
        // }

        // $client = ClientBuilder::create()
        //     ->setHosts([
        //         [
        //             'host' => env('ELASTICSEARCH_HOST'),
        //             'port' => env('ELASTICSEARCH_PORT'),
        //             'scheme' => env('ELASTICSEARCH_SCHEME'),
        //             'user' => env('ELASTICSEARCH_USER'),
        //             'pass' => env('ELASTICSEARCH_PASSWORD'),
        //         ],
        //     ])
        //     ->build();

        // $this->info('success');
        // if (!$client->ping()) {
        //     throw new \Exception('Error connecting to Elasticsearch: No alive nodes found in your cluster');
        // }

        $this->info("start indexing all users...");

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
