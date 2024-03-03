<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function __construct(protected AdminService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->getAllAdmins(),
            200
        );
    }

    public function show(Admin $admin): JsonResponse
    {
        return response()->json(
            $this->service->getAdmin($admin),
            200
        );
    }

    public function store(CreateAdminRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->createAdmin($request),
            201
        );
    }

    public function update(UpdateAdminRequest $request, Admin $admin): JsonResponse
    {
        return response()->json(
            $this->service->updateAdmin($request, $admin),
            201
        );
    }

    public function destroy(Admin $admin): JsonResponse
    {
        return response()->json(
            $this->service->deleteAdmin($admin),
            200
        );
    }
}
