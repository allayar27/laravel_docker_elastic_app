<?php

namespace App\Observers;

use App\Jobs\IndexUsersJob;
use App\Models\User;
use Elasticsearch;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        IndexUsersJob::dispatch($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        IndexUsersJob::dispatch($user);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        try {
            Elasticsearch::delete([
                'index' => 'users',
                'id' => $user->id,
            ]);
            Log::info("User with ID {$user->id} was successfully removed from the index.");
        } catch (\Exception $e) {
            Log::error("Failed to delete user with ID {$user->id} from index: " . $e->getMessage());
        }
    }
}
