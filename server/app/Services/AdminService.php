<?php

namespace App\Services;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class AdminService.
 */
class AdminService extends AbstractService
{
    public function __construct()
    {
        $this->setModel(Admin::class);
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
        // TODO
    }

    public function updateAdmin(UpdateAdminRequest $request, Admin $admin): Model
    {
        // TODO
    }

    public function deleteAdmin(Admin $admin): bool
    {
        return $this->deleteRecord($admin);
    }
}
