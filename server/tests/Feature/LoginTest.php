<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @Test Login a patient user.
     *
     * @return void
     */
    public function test_login_patient()
    {
        $response = $this->post('/api/patient/login', [
            'email' => 'peter.griffin@gmail.com',
            'password' => 'peter',
            'token_type' => User::$TOKEN_TYPE['0'],
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'token'
        ]);
    }

    /**
     * @Test login a doctor user.
     *
     * @return void
     */
    public function test_login_doctor()
    {
        $response = $this->post('/api/doctor/login', [
            'email' => 'teszt.doktor@medicare.com',
            'password' => 'doctor',
            'token_type' => User::$TOKEN_TYPE['1'],
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'token'
        ]);
    }

    /**
     * @Test login doctor user.
     *
     * @return void
     */
    public function test_login_admin()
    {
        $response = $this->post('/api/admin/login', [
            'email' => 'test.admin@medicare.com',
            'password' => 'test-admin',
            'token_type' => User::$TOKEN_TYPE['2'],
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'token'
        ]);
    }
}
