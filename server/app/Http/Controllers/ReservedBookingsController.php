<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservedBookingsRequest;
use App\Models\ReservedBookings;
use App\Services\ReservedBookingsService;
use Illuminate\Http\JsonResponse;

/**
 * @group Reserved Bookings
 *
 * Groups the APIs of Reserved Bookings,
 * that happens when a patient books an appointment.
 */
class ReservedBookingsController extends Controller
{
    public function __construct(protected ReservedBookingsService $service)
    {
    }

    /**
     * GET - every reserved booking's data.
     *
     * @authenticated
     * @apiResourceCollection App\Http\Resources\ReservedBookingsResource
     * @apiResourceModel App\Models\ReservedBookings
     *
     * @param ReservedBookingsRequest $request
     * @return JsonResponse
     */
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

    /**
     * GET - a reserved appointment's details.
     *
     * @authenticated
     * @apiResource App\Http\Resources\ReservedBookingsResource
     * @apiResourceModel App\Models\ReservedBookings
     *
     * @param ReservedBookings $booking
     * @return JsonResponse
     */
    public function show(ReservedBookings $booking): JsonResponse
    {
        return response()->json(
            $this->service->getBooking(
                $booking
            ),
            200
        );
    }

    /**
     * POST - book a reception time created by a doctor user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\ReservedBookingsResource
     * @apiResourceModel App\Models\ReservedBookings
     *
     * @param ReservedBookingsRequest $request
     * @return JsonResponse
     */
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
