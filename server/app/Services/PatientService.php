<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Http\Resources\UserResource;
use App\Models\PatientDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * Class PatientService.
 */
class PatientService extends AbstractService
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

    public function getPatientCollection(): AnonymousResourceCollection
    {
        return $this->getCollection();
    }

    public function getPatient(User $user): Model
    {
        return $this->getRecord($user);
    }

    public function updatePatient(PatientRequest $request, User $user): Model
    {
        return $this->updateRecord($user, $request);
    }

    public function deletePatient(User $user): bool
    {
        return $this->deleteRecord($user);
    }
}
