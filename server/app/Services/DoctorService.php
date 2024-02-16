<?php

namespace App\Services;

use App\Http\Requests\Doctor\CreateDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DoctorService.
 */
class DoctorService extends AbstractService
{
    protected function setModel(): string
    {
        return Doctor::class;
    }

    protected function setResource(): string
    {
        return DoctorResource::class;
    }

    public function __construct()
    {
        parent::__construct();
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
        $newDoctor = $request->all();

        return $this->createRecord($newDoctor);
    }

    public function updateDoctor(UpdateDoctorRequest $request, Doctor $doctor): Model
    {
        return $this->updateRecord($doctor, $request);
    }

    public function deleteDoctor(Doctor $doctor): bool
    {
        return $this->deleteRecord($doctor);
    }
}
