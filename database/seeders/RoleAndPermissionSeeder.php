<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission::create(['name' => 'view-users']);
        // Permission::create(['name' => 'create-users']);
        // Permission::create(['name' => 'edit-users']);
        // Permission::create(['name' => 'delete-users']);

        // Permission::create(['name' => 'view-tasks']);
        // Permission::create(['name' => 'create-tasks']);
        // Permission::create(['name' => 'edit-tasks']);
        // Permission::create(['name' => 'delete-tasks']);

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // $adminRole->givePermissionTo([

        //     'view-users',
        //     'create-users',
        //     'edit-users',
        //     'delete-users',

        //     'view-tasks',
        //     'create-tasks',
        //     'edit-tasks',
        //     'delete-tasks',
        // ]);

        // $userRole->givePermissionTo([
        //     'view-tasks',
        //     'create-tasks',
        //     'edit-tasks',
        //     'delete-tasks',
        // ]);
    }
}
