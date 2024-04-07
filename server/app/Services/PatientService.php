<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\Patient\PatientRequest;
use App\Http\Resources\UserResource;
use App\Models\PatientDetail;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->getCollection(
            [],
            [
                'filterUserRole' => UserRolesEnum::PATIENT->value
            ]
        );
    }

    public function getPatient(User $patient): UserResource|JsonResource
    {
        return $this->getRecord($patient);
    }

    public function updatePatient(PatientRequest $request, User $patient): UserResource|JsonResource
    {
        $isAdmin = $request->user()->roles->pluck('name')[0] == UserRolesEnum::ADMIN->value;

        PatientDetail::where('insurance_number', $patient->patient_details->insurance_number)
            ->update([
                'city' => $request->city ?? $patient->patient_details->city,
                'zip' => $request->zip ?? $patient->patient_details->zip,
                'street' => $request->street ?? $patient->patient_details->street,
                'house_number' => $request->house_number ?? $patient->patient_details->house_number,
                'phone' => $request->phone ?? $patient->patient_details->phone,
                'birthday' => $request->birthday ?? $patient->patient_details->birthday,
                'birthplace' => $request->birthplace ?? $patient->patient_details->birthplace,
                'insurance_number' => $request->insurance_number ?? $patient->patient_details->insurance_number,
            ]);


        $userData = [
            'email' => $request->email ?? $patient->email,
            'password' => $request->password ?? $patient->password,
            'first_name' => $request->first_name ?? $patient->first_name,
            'last_name' => $request->last_name ?? $patient->last_name,
        ];

        return $this->updateRecord($patient, $userData);
    }

    public function deletePatient(User $user): bool
    {
        return $this->deleteRecord($user);
    }
}
