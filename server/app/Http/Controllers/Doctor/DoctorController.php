<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Enums\UserRolesEnum;
use App\Http\Interfaces\ILoginable;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\DoctorService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Doctor Handling
 *
 * APIs for Doctor data.
 */
class DoctorController extends Controller implements ILoginable
{
    /**
     * @param DoctorService $doctorService
     * @param AuthService $authService
     */
    public function __construct(protected DoctorService $doctorService, protected  AuthService $authService)
    {
    }

    /**
     * Login process of doctor users.
     *
     * @response status=200 {
     *        "id": 4,
     *        "token": Bearer 4|qe$a21dadasd1313$qas
     * }
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->login($request, UserRolesEnum::DOCTOR->value),
            200
        );
    }

    /**
     * GET - every doctor user of the system.
     *
     * @authenticated
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            $this->doctorService->getEveryDoctor(),
            200
        );
    }

    /**
     * GET - the requested doctor data.
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @authenticated
     *
     * @param User $doctor
     * @return JsonResponse
     */
    public function show(User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->getDoctor($doctor),
            200
        );
    }

    /**
     * POST - create a new doctor.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param DoctorRequest $request
     * @return JsonResponse
     */
    public function store(DoctorRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    /**
     * PUT - modify the doctor whose id is sent.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param DoctorRequest $request
     * @param User $doctor
     * @return JsonResponse
     */
    public function update(DoctorRequest $request, User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->updateDoctor($request, $doctor),
            201
        );
    }

    /**
     * DELETE - delete the doctor user whose id is sent.
     *
     * @authenticated
     * @response status=200 {
     *     true
     * }
     * @response status=404 {
     *     false
     * }
     * @response status=500 {
     *     false
     * }
     *
     * @param User $doctor
     * @return JsonResponse
     */
    public function destroy(User $doctor): JsonResponse
    {
        return response()->json(
            $this->doctorService->deleteDoctor($doctor),
            200
        );
    }
}
