<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(30)->create();
        //Task::factory(30)->create();
        $this->call([
            RoleAndPermissionSeeder::class,
            AdminSeeder::class
        ]);
    }
}
