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

    public function index(ReservedBookingsRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->getEveryBooking(
                auth()->user()->id,
                $request->filters
            ),
            200
        );
    }

    public function show(ReservedBookings $booking): JsonResponse
    {
        return response()->json(
            $this->service->getBooking(
                $booking
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
}
