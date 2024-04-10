<?php

namespace App\Http\Controllers;

use App\Http\Enums\UserRolesEnum;
use App\Http\Requests\BookableReceptionTimesRequest;
use App\Models\BookableReceptionTimes;
use App\Services\ReceptionTimesService;
use Illuminate\Http\JsonResponse;

/**
 * @group Bookable Reception Times
 *
 * Groups the API methods of the Bookable Appointments.
 */
class BookableReceptionTimesController extends Controller
{
    public function __construct(protected ReceptionTimesService $service)
    {
    }

    /**
     * GET - every bookable reception times for a specific doctor.
     * If the requester user id a doctor it will get its own appointments.
     *
     * @authenticated
     * @apiResourceCollection App\Http\Resources\BookableReceptionResource
     * @apiResourceModel App\Models\BookableReceptionTimes
     *
     * @param BookableReceptionTimesRequest $request
     * @return JsonResponse
     */
    public function index(BookableReceptionTimesRequest $request): JsonResponse
    {
        $filters = $request->filters;
        $role = $request->user()->roles->pluck('name')[0];

        if ($request->user()->hasRole(UserRolesEnum::DOCTOR->value)) {
            $filters['doctor_id'] = auth()->user()->id;
        }

        return response()->json(
            $this->service->getEveryAppointments(
                $filters,
                $role
            ),
            200
        );
    }

    /**
     * GET - a bookable reception time.
     *
     * @authenticated
     * @apiResource App\Http\Resources\BookableReceptionResource
     * @apiResourceModel App\Models\BookableReceptionTimes
     *
     * @param BookableReceptionTimes $appointment
     * @return JsonResponse
     */
    public function show(BookableReceptionTimes $appointment): JsonResponse
    {
        return response()->json(
            $this->service->getAppointment($appointment),
            200
        );
    }

    /**
     * POST - create a bookable reception time.
     *
     * @authenticated
     * @apiResource App\Http\Resources\BookableReceptionResource
     * @apiResourceModel App\Models\BookableReceptionTimes
     *
     * @param BookableReceptionTimesRequest $request
     * @return JsonResponse
     */
    public function store(BookableReceptionTimesRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->createNewAppointment(
                $request->getParams()
            ),
            201
        );
    }

    /**
     * PUT - modify a bookable reception time.
     * It can be modified if a patient user is not
     * booked it.
     *
     * @authenticated
     * @apiResource App\Http\Resources\BookableReceptionResource
     * @apiResourceModel App\Models\BookableReceptionTimes
     *
     * @param BookableReceptionTimesRequest $request
     * @param BookableReceptionTimes $appointment
     * @return JsonResponse
     */
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

    /**
     * DELETE - delete a bookable reception time.
     * It can not be deleted if a patient user booked.
     *
     * @authenticated
     * @response status=200 {
     *      true
     * }
     * @response status=500 {
     *      'success': false,
     *      'message': 'You can'\t delete this appointment, because it is booked. Please contact administrator.'
     * }
     *
     * @param BookableReceptionTimes $appointment
     * @return JsonResponse
     */
    public function destroy(BookableReceptionTimes $appointment): JsonResponse
    {
        return response()->json(
            $this->service->deleteAppointment($appointment),
            204
        );
    }
}
