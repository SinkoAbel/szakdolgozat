<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\UserRolesEnum;
use App\Http\Interfaces\ILoginable;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AdminService;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Handling
 *
 * APIs for Admin data.
 */
class AdminController extends Controller implements ILoginable
{
    public function __construct(protected AdminService $adminService, protected AuthService $authService)
    {
    }

    /**
     * Login process of admins users.
     *
     * @response status=200 {
     *       "id": 4,
     *       "token": Bearer 4|qe$a21dadasd1313$qas
     *  }
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->login($request, UserRolesEnum::ADMIN->value),
            200
        );
    }

    /**
     * GET all admin users.
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
            $this->adminService->getAllAdmins(),
            200
        );
    }

    /**
     * GET - the requested admin user data.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param User $admin
     * @return JsonResponse
     */
    public function show(User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->getAdmin($admin),
            200
        );
    }

    /**
     * POST - create a new admin user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param AdminRequest $request
     * @return JsonResponse
     */
    public function store(AdminRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    /**
     * PUT - update the specific admin user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param AdminRequest $request
     * @param User $admin
     * @return JsonResponse
     */
    public function update(AdminRequest $request, User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->updateAdmin($request, $admin),
            201
        );
    }

    /**
     * DELETE - delete the specific admin user.
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
     * @param User $admin
     * @return JsonResponse
     */
    public function destroy(User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->deleteAdmin($admin),
            200
        );
    }
}
