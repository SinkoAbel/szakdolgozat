<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->userService->getAllUsers(),
            200
        );
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(
            $this->userService->getUser($user),
            200
        );
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        return response()->json(
            $this->userService->createUser($request),
            201
        );
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return response()->json(
            $this->userService->updateUser($request, $user),
            201
        );
    }

    public function destroy(User $user): JsonResponse
    {
        $userDeleted = $this->userService->deleteUser($user);

        if ($userDeleted) {
            return response()->json([
                'message' => 'User deleted successfully.'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Delete was not successful!'
            ], 500);
        }
    }
}
