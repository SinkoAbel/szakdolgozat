<?php

namespace App\Services;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class AdminService.
 */
class AdminService extends AbstractService
{
    protected function setModel(): string
    {
        return Admin::class;
    }

    protected function setResource(): string
    {
        return AdminResource::class;
    }

    public function __construct()
    {
        parent::__construct();
    }
    public function getAllAdmins(): Collection
    {
        return $this->getCollection();
    }

    public function getAdmin(Admin $admin): Model
    {
        return $this->getRecord($admin);
    }

    public function createAdmin(CreateAdminRequest $request): Model
    {
        $newUser = $request->all();

        return $this->createRecord($newUser);
    }

    public function updateAdmin(UpdateAdminRequest $request, Admin $admin): Model
    {
        return $this->updateRecord($admin, $request);
    }

    public function deleteAdmin(Admin $admin): bool
    {
        return $this->deleteRecord($admin);
    }

    public function login(LoginAdminRequest $request): array
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->model::where('email', $credentials['email'])->first();
            $token = $user->createToken('Admin Token')->plainTextToken;

            return [
                'token' => $token
            ];
        }

        return [
            'status' => '401',
            'message' => 'Wrong credentials!'
        ];
    }
}
