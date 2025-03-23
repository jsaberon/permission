<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'user:create', 'description' => 'Create user'],
            ['name' => 'user:update', 'description' => 'Update user'],
            ['name' => 'user:update-any', 'description' => 'Update any user'],
            ['name' => 'user:delete', 'description' => 'Delete user'],
            ['name' => 'user:delete-any', 'description' => 'Delete any user'],
            ['name' => 'role:create', 'description' => 'Create role'],
            ['name' => 'role:update', 'description' => 'Update role'],
            ['name' => 'role:update-any', 'description' => 'Update any role'],
            ['name' => 'role:delete', 'description' => 'Delete role'],
            ['name' => 'role:delete-any', 'description' => 'Delete any role'],
            ['name' => 'permission:create', 'description' => 'Create permission'],
            ['name' => 'permission:update', 'description' => 'Update permission'],
            ['name' => 'permission:update-any', 'description' => 'Update any permission'],
        ]);

        //
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $adminRole = Role::factory()->create([
            'name' => 'super-admin',
        ]);

        $adminUser->roles()->attach($adminRole);

        $permissionUser = User::factory()->create([
            'name' => 'Permission user',
            'email' => 'permission@example.com',
        ]);

        $permissionRole = Role::factory()->create([
            'name' => 'permission',
        ]);

        $permissionRole->permissions()->sync(Permission::where('name', 'like', 'permission%')->get());
        $permissionUser->roles()->attach($permissionRole);

        $roleUser = User::factory()->create([
            'name' => 'Role user',
            'email' => 'role@example.com',
        ]);

        $roleRole = Role::factory()->create([
            'name' => 'role',
        ]);

        $roleRole->permissions()->sync(Permission::where('name', 'like', 'role%')->get());
        $roleUser->roles()->attach($roleRole);

        $roleUser = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        $roleRole = Role::factory()->create([
            'name' => 'user',
        ]);

        $roleRole->permissions()->sync(Permission::where('name', 'like', 'user%')->get());
        $roleUser->roles()->attach($roleRole);
    }
}
