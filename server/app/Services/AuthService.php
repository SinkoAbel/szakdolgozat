<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\PatientDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService.
 */
class AuthService extends AbstractService
{
    protected function setModel(): string
    {
        return User::class;
    }

    protected function setResource(): string
    {
        return UserResource::class;
    }

    public function register(UserRequest $request): UserResource
    {
        $role = $request->role;

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = $this->createUserRecord($userData, $role);

        if (strtolower($role) == UserRolesEnum::PATIENT->value) {
            PatientDetail::create([
                'user_id' => $user->id,
                'birthday' => $request->birthday,
                'birthplace' => $request->birthplace,
                'city' => $request->city,
                'zip' => $request->zip,
                'street' => $request->street,
                'house_number' => $request->house_number,
                'insurance_number' => $request->insurance_number,
                'phone' => $request->phone,
            ]);
        }

        return $user;
    }

    public function login(LoginRequest $loginRequest): string|array
    {
        $credentials = $loginRequest->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->model::where('email', $credentials['email'])->first();
            return $user->createToken($loginRequest->tokenType)->plainTextToken;
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
