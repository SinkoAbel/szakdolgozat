<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\CreatePatientRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Models\User;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;


class PatientController extends Controller
{
    public function __construct(protected PatientService $userService)
    {
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

    public function store(CreatePatientRequest $request): JsonResponse
    {
        return response()->json(
            $this->userService->registerUser($request),
            201
        );
    }

    public function update(UpdatePatientRequest $request, User $user): JsonResponse
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
