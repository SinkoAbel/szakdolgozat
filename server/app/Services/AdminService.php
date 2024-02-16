<?php

namespace App\Services;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
