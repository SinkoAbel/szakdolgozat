<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Enums\UserRolesEnum;
use App\Http\Interfaces\ILoginable;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\PatientService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Patient Handling
 *
 * APIs for Patient data.
 */
class PatientController extends Controller implements ILoginable
{
    public function __construct(protected PatientService $userService, protected AuthService $authService)
    {
    }

    /**
     * Login process of patients.
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
            $this->authService->login($request, UserRolesEnum::PATIENT->value),
            200
        );
    }

    /**
     * GET - get every patient users of the system.
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
            $this->userService->getPatientCollection(),
            200
        );
    }

    /**
     * GET - get the requested patient user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param User $patient
     * @return JsonResponse
     */
    public function show(User $patient): JsonResponse
    {
        return response()->json(
            $this->userService->getPatient($patient),
            200
        );
    }

    /**
     * POST - create/register a new patient user.
     *
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param PatientRequest $request
     * @return JsonResponse
     */
    public function store(PatientRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    /**
     * UPDATE - modify patient users data.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param PatientRequest $request
     * @param User $patient
     * @return JsonResponse
     */
    public function update(PatientRequest $request, User $patient): JsonResponse
    {
        return response()->json(
            $this->userService->updatePatient($request, $patient),
            201
        );
    }

    /**
     * DELETE - delete a specific patient user.
     *
     * @authenticated
     * @response status=200 {
     *     ['message': User deleted successfully.]
     * }
     * @response status=500 {
     *     ['message': 'Delete was not successful!']
     * }
     *
     * @param User $patient
     * @return JsonResponse
     */
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
