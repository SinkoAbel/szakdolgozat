<?php

namespace App\Http\Controllers;

use App\Services\UserAuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    private UserService $userService;
    private UserAuthService $userAuthService;
  
    public function __construct(UserService $userService, UserAuthService $userAuthService)
    {
        $this->userService = $userService;
        $this->userAuthService = $userAuthService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users, 200);
    }

    public function getUser(int $id): JsonResponse
    {
        $user = $this->userService->getUserByID($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validatedUser = $this->userAuthService->validateUserData($request);

        $updatedUser = $this->userService->modifyUser($validatedUser, $id);
        return response()->json($updatedUser, 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $userDeleted = $this->userService->deleteUser($id);

        if ($userDeleted) {
            $data = [
                'message' => 'User deleted successfully.'
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'User was not found'
            ];

            return response()->json($data, 404);
        }
    }
}
