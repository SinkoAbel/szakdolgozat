<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\CreatePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
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

    public function getAllUsers(): AnonymousResourceCollection
    {
        return $this->getCollection();
    }

    public function getUser(User $user): Model
    {
        return $this->getRecord($user);
    }

    public function registerUser(CreatePatientRequest $request): Model
    {
        $role = $request->role();

        $patientDetail = PatientDetail::create([
            'birthday' => $request->birthday,
            'birthplace' => $request->birthplace,
            'city' => $request->city,
            'zip' => $request->zip,
            'street' => $request->street,
            'house_number' => $request->house_number,
            'insurance_number' => $request->insurance_number,
            'phone' => $request->phone,
        ]);

        $userData = [
            'patient_detail_id' => $patientDetail->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        return $this->createUserRecord($userData, 'patient');
    }

    public function updateUser(UpdatePatientRequest $request, User $user): Model
    {
        return $this->updateRecord($user, $request);
    }

    public function deleteUser(User $user): bool
    {
        return $this->deleteRecord($user);
    }

    // TODO: place this to AuthController.php
    public function login(LoginRequest $loginRequest): array
    {
        $credentials = $loginRequest->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->model::where('email', $credentials['email'])->first();
            $token = $user->createToken('User Token')->plainTextToken;

            return [
                'token' => $token
            ];
        }

        return [
            'status' => '401',
            'message' => 'Wrong credentials!'
        ];
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}
