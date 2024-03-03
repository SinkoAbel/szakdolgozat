<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        return $this->getCollection();
    }

    public function getAdmin(User $admin): Model
    {
        return $this->getRecord($admin);
    }

    public function updateAdmin(UserRequest $request, User $admin): Model
    {
        return $this->updateRecord($admin, $request);
    }

    public function deleteAdmin(User $admin): bool
    {
        return $this->deleteRecord($admin);
    }
}
