<?php

namespace Database\Seeders;

use App\Http\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test Patient
        $patient = User::create([
            "first_name"       => "Peter",
            "last_name"        => "Griffin",
            "email"            => "peter.griffin@gmail.com",
            "password"         => "peter",
        ]);

        // Create patient details.
        $patient->patient_details()->create([
            "birthday"         => "1967-11-05",
            "birthplace"       => "Quahog",
            "city"             => "Quahog",
            "zip"              => "5121",
            "street"           => "Spooner str.",
            "house_number"     => "32",
            "insurance_number" => "234 124 842",
            "phone"            => "+36 13 123 7342",
        ]);

        $patient->assignRole(UserRolesEnum::PATIENT->value);

        // Test Doctor
        $doctor = User::create([
            "first_name" => "Teszt",
            "last_name"  => "Doktor",
            "email"      => "teszt.doktor@medicare.com",
            "password"   => "doctor",
        ]);

        $doctor->assignRole(UserRolesEnum::DOCTOR->value);

        // Test Admin
        $admin = User::create([
            "first_name" => "Test",
            "last_name"  => "Admin",
            "email"      => "test.admin@medicare.com",
            "password"   => "test-admin",
        ]);

        $admin->assignRole(UserRolesEnum::ADMIN->value);
    }
}
