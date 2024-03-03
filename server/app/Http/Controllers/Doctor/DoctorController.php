<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\CreateDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Http\JsonResponse;

class DoctorController extends Controller
{
    protected DoctorService $service;

    /**
     * @param DoctorService $service
     */
    public function __construct(DoctorService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->getEveryDoctor(),
            200
        );
    }

    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json(
            $this->service->getDoctor($doctor),
            200
        );
    }

    public function store(CreateDoctorRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->createDoctor($request),
            201
        );
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): JsonResponse
    {
        return response()->json(
            $this->service->updateDoctor($request, $doctor),
            201
        );
    }

    public function destroy(Doctor $doctor): JsonResponse
    {
        return response()->json(
            $this->service->deleteDoctor($doctor),
            200
        );
    }
}
