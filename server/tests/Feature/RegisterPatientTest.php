<?php

namespace Tests\Feature;

use App\Http\Enums\UserRolesEnum;
use Tests\TestCase;

class RegisterPatientTest extends TestCase
{
    private string $adminToken = 'Bearer 1|k7ecLsPygr4EveZRl9CdJldcpl1lKl312ZDBmWfWe5eaedd3';

    /**
     * @Test Create a new patient and $id variable.
     */
    public function test_create_new_patient(): void
    {

        $response = $this->post('/api/patient/register', [
            'first_name' => 'TestF',
            'last_name' => 'TestL',
            'email' => 'test.patient@email.com',
            'password' => 'test',
            'role' => UserRolesEnum::PATIENT->value,
            'birthday' => "1998-10-28",
            'birthplace' => 'Testvillage',
            'city' => 'TestCity',
            'zip' => "2222",
            'street' => 'Test str.',
            'house_number' => "22",
            'insurance_number' => '111 111 111',
            'phone' => '+36 1 111 1111'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'email',
            'patient_detail' => [
                'id',
                'birthday',
                'birthplace',
                'city',
                'zip',
                'street',
                'house_number',
                'insurance_number',
                'phone'
            ],
            'role',
        ]);
    }

    /**
     * @Test Unsuccessful delete request
     */
    public function test_failed_delete_test()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->adminToken
        ])->delete("/api/super/patients/99999999999999999999999999999");

        $response->assertStatus(404);
    }
}
