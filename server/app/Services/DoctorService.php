<?php

namespace App\Services;

use App\Http\Requests\Doctor\CreateDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DoctorService.
 */
class DoctorService extends AbstractService
{
    protected string $model;

    public function __construct()
    {
        $this->setModel(Doctor::class);
    }

    public function getEveryDoctor(): Collection
    {
        return $this->getCollection();
    }

    public function getDoctor(Doctor $doctor): Model
    {
        return $this->getRecord($doctor);
    }

    public function createDoctor(CreateDoctorRequest $request): Model
    {
        $newDoctor = [
            // TODO
        ];

        return $this->createRecord($newDoctor);
    }

    // TODO: here the abstract method can be a problem, 'cause what record are we updating?
    public function updateDoctor(UpdateDoctorRequest $request, Doctor $doctor): Model
    {
        $foundDoctor = $this->getDoctor($doctor);
        $modifiedData = [
            // TODO
        ];

        return $this->updateRecord($modifiedData);
    }

    public function deleteDoctor(Doctor $doctor): bool
    {
        return $this->deleteRecord($doctor);
    }
}
