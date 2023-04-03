<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
        $super_admin->syncPermissions($permissions);

        $admin->syncPermissions($permissions->filter(
            fn ($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'tags',
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
                    'logs'
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
                    'logs'
                ]
            )
        )->toArray());
    }
}
