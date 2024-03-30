<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
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


    /**
     * Register new User for the system.
     *
     * @param UserRequest $request
     * @return JsonResource
     */
    public function register(UserRequest $request): JsonResource
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
            $user->patient_details()->create([
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

        return new $this->resource($user);
    }

    /**
     * Handle login, issue new token,
     * and return it with ID.
     *
     * @param LoginRequest $loginRequest
     *
     * @return array
     * @throws Exception
     */
    public function login(LoginRequest $loginRequest): array
    {
        $credentials = $loginRequest->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->model::where('email', $credentials['email'])->first();
            $token = $user->createToken($loginRequest->token_type)->plainTextToken;

            return [
                'id' => $user->id,
                'token' => $token
            ];
        }

        throw new Exception('Wrong credentials', 401);
    }

}
