<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    /**
     * @param DoctorService $service
     */
    public function __construct(protected DoctorService $doctorService, protected  AuthService $authService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->doctorService->getEveryDoctor(),
            200
        );
    }

    public function show(User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->getDoctor($doctor),
            200
        );
    }

    public function store(DoctorRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    public function update(DoctorRequest $request, User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->updateDoctor($request, $doctor),
            201
        );
    }

    public function destroy(User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->deleteDoctor($doctor),
            200
        );
    }
}
