<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservedBookingsRequest;
use App\Models\ReservedBookings;
use App\Services\ReservedBookingsService;
use Illuminate\Http\JsonResponse;

class ReservedBookingsController extends Controller
{
    public function __construct(protected ReservedBookingsService $service)
    {        
    }
    
    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->getEveryBooking(),
            200
        );
    }

    public function show(ReservedBookings $booking): JsonResponse
    {
        return response()->json(
            $this->service->getBooking(
                $booking,
                $request->getParams()
            ),
            200
        );
    }

    public function store(ReservedBookingsRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->bookAppointment(
               $request->getParams()
            ),
            201
        );
    }

    // TODO: see if these
    /*
    public function update(ReservedBookingsRequest $request, ReservedBookings $booking): JsonResponse
    {
        return response()->json();
    }

    public function destroy(ReservedBookingsRequest $request, ReservedBookings $booking): JsonResponse
    {
        return response()->json();
    }*/
}
