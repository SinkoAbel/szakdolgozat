<?php

namespace App\Services;

use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class DoctorService.
 */
class DoctorService extends AbstractService
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

    public function getEveryDoctor(): AnonymousResourceCollection
    {
        return $this->getCollection();
    }

    public function getDoctor(User $doctor): UserResource
    {
        return $this->getRecord($doctor);
    }

    public function updateDoctor(DoctorRequest $request, User $doctor): UserResource
    {
        return $this->updateRecord($doctor, $request);
    }

    public function deleteDoctor(User $doctor): bool
    {
        return $this->deleteRecord($doctor);
    }
}
