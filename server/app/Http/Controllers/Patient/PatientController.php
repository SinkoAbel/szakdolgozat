<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
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

    public function index(): JsonResponse
    {
        return response()->json(
            $this->userService->getPatientCollection(),
            200
        );
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(
            $this->userService->getPatient($user),
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

    public function update(PatientRequest $request, User $user): JsonResponse
    {
        return response()->json(
            $this->userService->updatePatient($request, $user),
            201
        );
    }

    public function destroy(User $user): JsonResponse
    {
        $userDeleted = $this->userService->deletePatient($user);

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
