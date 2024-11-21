<?php

namespace App\Jobs;

use App\Models\Task;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Elasticsearch;

class IndexTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Start indexing all tasks...');

        // Проверка наличия индекса, создание при необходимости
        if (!Elasticsearch::indices()->exists(['index' => 'tasks'])) {
            Elasticsearch::indices()->create([
                'index' => 'tasks',
                'body' => [
                    'settings' => [
                        'number_of_shards' => 1,
                        'number_of_replicas' => 1,
                    ],
                    'mappings' => [
                        'properties' => [
                            'title' => [
                                'type' => 'text',
                            ],
                        ]
                    ]
                ]
            ]);
            Log::info("Index 'tasks' created with mappings.");
        }

        // Индексация данных с использованием bulk
        $tasks = Task::all();
        $bulkData = [];

        foreach ($tasks as $task) {
            $bulkData['body'][] = [
                'index' => [
                    '_index' => 'tasks',
                    '_id' => $task->id,
                ]
            ];
            $bulkData['body'][] = [
                'title' => $task->title,
            ];
        }

        try {
            if (!empty($bulkData)) {
                Elasticsearch::bulk($bulkData);
                Log::info("tasks were successfully indexed in bulk.");
            } else {
                info("No tasks to index.");
            }
        } catch (Exception $e) {
            Log::error("Failed to index tasks: " . $e->getMessage());
        }
    }
}
