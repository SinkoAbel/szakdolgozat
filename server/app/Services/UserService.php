<?php

namespace App\Services;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class UserService.
 */
class UserService
{
    protected string $model;

    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllUsers(): Collection
    {
        return $this->model::all();
    }

    public function getUser(User $user): User
    {
        return $this->model::find($user);
    }

    public function createUser(CreateUserRequest $request): User
    {
        $newUserData = [

        ];

        return $this->model::create($newUserData);
    }

    public function updateUser(UpdateUserRequest $request, User $user): User
    {
        $foundUser = $this->model::find($user);

        return $this->model::update($foundUser);
    }

    public function deleteUser(User $user): bool
    {
        return $this->model::delete($user);
    }

    public function login(Request $loginRequest)
    {
        $isCredentialsCorrect = auth()->attempt([
            'email' => $loginRequest->input('email'),
            'password' => $loginRequest->input('password')
        ]);

        if (!$isCredentialsCorrect) {
            return [
                'status' => 401,
                'errorMessage' => 'You\'re not authorized',
            ];
        }

        $token = auth()->user()->createToken('personal-token')->plainTextToken;
        return ['token' => $token];
    }

    public function logout(Request $request)
    {
        return $request->user()->currentAccessToken()->delete();
    }
}
