<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AdminService.
 */
class AdminService extends AbstractService
{
    protected function setModel(): string
    {
        return User::class;
    }

    protected function setResource(): string
    {
        return UserResource::class;
    }

    public function __construct()
    {
        parent::__construct();
    }
    public function getAllAdmins(): AnonymousResourceCollection
    {
        return $this->getCollection(
            [],
            [
                'filterUserRole' => UserRolesEnum::ADMIN->value
            ]
        );
    }

    public function getAdmin(User $admin): JsonResource
    {
        return $this->getRecord($admin);
    }

    public function updateAdmin(UserRequest $request, User $admin): JsonResource
    {
        $updatedObject = [
            'first_name' => $request->first_name ?? $admin->first_name,
            'last_name' => $request->last_name ?? $admin->last_name,
            'email' => $request->email ?? $admin->email,
        ];

        if (isset($request->password)) {
            $updatedObject['password'] = $request->password;
        }

        return $this->updateRecord($admin, $updatedObject);
    }

    public function deleteAdmin(User $admin): bool
    {
        return $this->deleteRecord($admin);
    }
}
