<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $super_user = Role::create(['name' => 'super-user']);
        $user = Role::create(['name' => 'user']);

        $permissions = collect(config('permission.permissions'))->keys();

        $permissions_with_guard = collect($permissions->toArray())->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions_with_guard->toArray());

        $super_admin->syncPermissions($permissions);

        $admin->syncPermissions($permissions->filter(
            fn ($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'answers',
                    'logs'
                ]
            )
        )->toArray());

        $super_user->syncPermissions($permissions->filter(
            fn ($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'tags',
                    'categories',
                    'logs',
                    'handle'
                ]
            )
        )->toArray());

        $user->syncPermissions($permissions->filter(
            fn ($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'tags',
                    'answers',
                    'categories',
                    'logs',
                    'handle'
                ]
            )
        )->toArray());
    }
}
