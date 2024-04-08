<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->getCollection(
            [],
            [
                'filterUserRole' => UserRolesEnum::DOCTOR->value
            ]
        );
    }

    public function getDoctor(User $doctor): JsonResource
    {
        return $this->getRecord($doctor);
    }

    public function updateDoctor(DoctorRequest $request, User $doctor): JsonResource
    {
        $doctorData = [
            'first_name' => $request->first_name ?? $doctor->first_name,
            'last_name' => $request->last_name ?? $doctor->last_name,
            'email' => $request->email ?? $doctor->email,
        ];

        if (isset($request->password)) {
            $doctorData['password'] = $request->password;
        }

        return $this->updateRecord($doctor, $doctorData);
    }

    public function deleteDoctor(User $doctor): bool
    {
        return $this->deleteRecord($doctor);
    }
}
