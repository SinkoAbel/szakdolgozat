<?php

namespace App\Services;

use App\Models\User;
use Exception;
use http\Env\Request;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserService.
 */
class UserService
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Collection of Users
     */
    public function getAllUsers(): Collection
    {
        return $this->user->all();
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserByID(int $id): User
    {
        return $this->user->find($id);
    }

    /**
     * @param Request $user
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function modifyUser(Request $user, int $id): User
    {
        $user = User::find($id);

        if ($user == null) {
            throw new Exception("User not found.");
        }

        // 1. update user data
        // 2. save user
        // 3. return modified user
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);

        if ($user == null) {
            return false;
        }

        $user->delete();
        return true;
    }
}
