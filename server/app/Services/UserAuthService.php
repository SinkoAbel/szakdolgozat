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
    public function registerUser(): User
    {
        // TODO:
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
