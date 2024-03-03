<?php

namespace Database\Seeders;

use App\Http\Enums\UserRolesEnum;
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
            'name' => UserRolesEnum::PATIENT,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => UserRolesEnum::DOCTOR,
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => UserRolesEnum::ADMIN,
            'guard_name' => 'web',
        ]);

        // API guard
        Role::create([
            'name' => UserRolesEnum::PATIENT,
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => UserRolesEnum::DOCTOR,
            'guard_name' => 'api',
        ]);
        Role::create([
            'name' => UserRolesEnum::ADMIN,
            'guard_name' => 'api',
        ]);
    }
}
