<?php

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class UserService.
 */
class UserService extends AbstractService
{
    public function __construct()
    {
        $this->setModel(User::class);
    }

    public function getAllUsers(): Collection
    {
        return $this->getCollection();
    }

    public function getUser(User $user): Model
    {
        return $this->getRecord($user);
    }

    public function createUser(CreateUserRequest $request): Model
    {
        $newUserData = [
            // TODO
        ];

        return $this->createRecord($newUserData);
    }

    // TODO: here the abstract method can be a problem, 'cause what record are we updating?
    public function updateUser(UpdateUserRequest $request, User $user): Model
    {
        // TODO
        $foundUser = $this->model::find($user);

        return $this->updateRecord($foundUser);
    }

    public function deleteUser(User $user): bool
    {
        return $this->deleteRecord($user);
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
