<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservedBookingsRequest;
use App\Models\ReservedBookings;
use Illuminate\Http\JsonResponse;

class ReservedBookingsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json();
    }

    public function show(ReservedBookingsRequest $request): JsonResponse
    {
        return response()->json();
    }

    public function store(ReservedBookingsRequest $request): JsonResponse
    {
        return response()->json();
    }

    public function update(ReservedBookingsRequest $request, ReservedBookings $booking): JsonResponse
    {
        return response()->json();
    }

    public function destroy(ReservedBookingsRequest $request, ReservedBookings $booking): JsonResponse
    {
        return response()->json();
    }
}
