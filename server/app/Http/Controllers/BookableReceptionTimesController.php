<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookableReceptionTimesRequest;
use App\Services\ReceptionTimesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookableReceptionTimesController extends Controller
{
    public function __construct(protected ReceptionTimesService $service)
    {
    }

    public function index()
    {
        // TODO: show all appointments created
    }

    public function show()
    {
        // TODO: show an appointment
    }

    public function store(BookableReceptionTimesRequest $request): JsonResponse
    {
        // TODO: store new Reception Time created by Doctor
        return response()->json(
            $this->service->createNewAppointment(
                $request->getParams()
            ),
            200
        );
    }

    public function update()
    {
        // TODO: update existing Reception Time created by Doctor
        // TODO: if patient booked Doctor can't modify appointment
    }

    public function destroy()
    {
        // TODO: delete an existing Reception Time created by Doctor
        // TODO: if patient booked Doctor can't delete appointment
    }
}
