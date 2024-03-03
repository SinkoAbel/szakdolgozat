<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // WEB Guard
        Role::create([
            'name' => 'patient',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'doctor',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // API guard
        Role::create([
            'name' => 'patient',
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => 'doctor',
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'api',
        ]);
    }
}
