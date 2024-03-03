<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\User;
use App\Services\AdminService;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminService, protected AuthService $authService)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->adminService->getAllAdmins(),
            200
        );
    }

    public function show(User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->getAdmin($admin),
            200
        );
    }

    public function store(AdminRequest $request): JsonResponse
    {
        return response()->json(
            $this->authService->register($request),
            201
        );
    }

    public function update(AdminRequest $request, User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->updateAdmin($request, $admin),
            201
        );
    }

    public function destroy(User $admin): JsonResponse
    {
        return response()->json(
            $this->adminService->deleteAdmin($admin),
            200
        );
    }
}
