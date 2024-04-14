<?php

namespace Tests\Feature;

use App\Http\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminFeatureTest extends TestCase
{
    /**
     * ID of the admin.
     *
     * @var string
     */
    public string $id;

    /**
     * Token of the admin.
     *
     * @var string
     */
    public string $token;

    /**
     * Testing endpoint.
     *
     * @var string
     */
    public string $endpoint;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $response = $this->post('/api/admin/login', [
            'email' => 'test.admin@medicare.com',
            'password' => 'test-admin',
            'token_type' => User::$TOKEN_TYPE['2'],
        ]);

        $this->id = $response['id'];
        $this->token = $response['token'];

        $this->endpoint = '/api/super';
    }

    public function test_create_admin_user(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->postJson("$this->endpoint/admins", [
            'first_name' => 'Teszt',
            'last_name' => 'Admin',
            'email' => 'admin.admin@medicare.com',
            'password' => 'teszt',
            'role' => UserRolesEnum::ADMIN->value,
        ]);

        $response->assertStatus(201);
    }

    /**
     * @Test
     * Get the created admin user.
     *
     * @return void
     */
    public function test_get_created_admin_user(): void
    {
        $admin = User::where('email', 'admin.admin@medicare.com')->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->get("$this->endpoint/admins/" . $admin->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'email',
            'patient_detail',
            'role',
        ]);

        $this->assertEquals(UserRolesEnum::ADMIN->value, $response['role'][0]['name']);
    }

    public function test_update_created_admin_user(): void
    {
        $admin = User::where('email', 'admin.admin@medicare.com')->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->putJson("$this->endpoint/admins/" . $admin->id, [
            'first_name' => 'Another',
            'last_name' => 'Test'
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'first_name',
            'last_name',
            'email',
            'patient_detail',
            'role',
        ]);

        $this->assertEquals('Another', $response['first_name']);
        $this->assertEquals('Test', $response['last_name']);
    }

    public function test_delete_created_admin_user(): void
    {
        $admin = User::where('email', 'admin.admin@medicare.com')->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->delete("$this->endpoint/admins/" . $admin->id);

        $response->assertStatus(200);
    }
}
