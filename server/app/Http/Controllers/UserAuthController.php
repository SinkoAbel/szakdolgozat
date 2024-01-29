<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Services\UserAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    private UserAuthService $authService;
    private static string $ERROR_KEY = 'errorMessage';

    /**
     * @param UserAuthService $authService
     */
    public function __construct(UserAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $loginArray = $this->authService->login($request);

        if (array_key_exists(self::$ERROR_KEY, $loginArray))
        {
            return response()->json($loginArray, 401);
        }

        return response()->json($loginArray, 200);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
    }

     public function register(RegisterRequest $request): JsonResponse
    {
        $validatedUserData = $this->authService->validateUserData($request);
        if (!$validatedUserData) {
            return response()->json([self::$ERROR_KEY => 'Invalid data'], 500);
        }

        $newUser = $this->authService->register($validatedUserData);
        return response()->json($newUser, 201);
    }
}
