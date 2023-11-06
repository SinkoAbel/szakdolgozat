<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use http\Env\Request;

/**
 * Class UserAuthService.
 */
class UserAuthService
{
    public function register(Request $userRequest): User
    {
        $hashedPassword = Hash::make($userRequest->input('password'));

        return User::create([
            'name' => $userRequest->input('name'),
            'email' => $userRequest->input('email'),
            'password' => $userRequest->input($hashedPassword),
        ]);
    }

    public function login()
    {
        //
    }

    public function logout()
    {
        //
    }

    public function validateUserData(Request $request): Request
    {
        return $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255',
            'confirm_password' => 'required|same:password'
        ]);
    }

}
