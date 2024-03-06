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

    public function getPatient(User $patient): UserResource
    {
        return $this->getRecord($patient);
    }

    public function updatePatient(PatientRequest $request, User $patient): UserResource
    {   
        PatientDetail::where('insurance_number', $request->insurance_number)
            ->update([
                'city' => $request->city,
                'zip' => $request->zip,
                'street' => $request->street,
                'house_number' => $request->house_number,
                'phone' => $request->phone,
            ]);

        
        $userData = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        return $this->updateRecord($patient, $userData);
    }

    public function deletePatient(User $user): bool
    {
        return $this->deleteRecord($user);
    }
}
