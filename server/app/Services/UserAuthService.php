<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/**
 * Class UserAuthService.
 */
class UserAuthService
{
    public function register(array $userArray): User
    {
        return User::create([
            'name' => $userArray['name'],
            'email' => $userArray['email'],
            'password' => $userArray['password'],
        ]);
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

    public function validateUserData(Request $request): array | bool
    {
        try {
            return $request->validate([
                'name' => 'required|unique:users|max:255',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|max:255',
                'confirm_password' => 'required|same:password'
            ]);
        } catch (Exception $ex) {
            return false;
        }
    }

}
