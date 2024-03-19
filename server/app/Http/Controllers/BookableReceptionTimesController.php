<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookableReceptionTimesRequest;
use App\Models\BookableReceptionTimes;
use App\Services\ReceptionTimesService;
use Illuminate\Http\JsonResponse;

class BookableReceptionTimesController extends Controller
{
    public function __construct(protected ReceptionTimesService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->getEveryAppointments(),
            200
        );
    }

    public function show(BookableReceptionTimes $appointment): JsonResponse
    {
        return response()->json(
            $this->service->getAppointment($appointment),
            200
        );
    }

    public function store(BookableReceptionTimesRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->createNewAppointment(
                $request->getParams()
            ),
            201
        );
    }

    public function update(BookableReceptionTimesRequest $request, BookableReceptionTimes $appointment): JsonResponse
    {
        return response()->json(
            $this->service->modifyAppointment(
                    $appointment,
                    $request->getParams()
            ),
            201
        );
    }

    public function destroy(BookableReceptionTimes $appointment): JsonResponse
    {
        return response()->json(
            $this->service->deleteAppointment($appointment),
            204
        );
    }
}
