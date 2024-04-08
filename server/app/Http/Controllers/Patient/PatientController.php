<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;


class PatientController extends Controller
{
    public function __construct(protected PatientService $userService, protected AuthService $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->login($request, UserRolesEnum::PATIENT->value),
            200
        );
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->userService->getPatientCollection(),
            200
        );
    }

    public function show(User $patient): JsonResponse
    {
        return response()->json(
            $this->userService->getPatient($patient),
            200
        );
    }

    public function store(PatientRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    public function update(PatientRequest $request, User $patient): JsonResponse
    {
        return response()->json(
            $this->userService->updatePatient($request, $patient),
            201
        );
    }

    public function destroy(User $patient): JsonResponse
    {
        $userDeleted = $this->userService->deletePatient($patient);

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
