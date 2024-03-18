<?php

namespace App\Http\Controllers;

use App\Services\RouteService;
use Illuminate\Http\JsonResponse;

class RouteController extends Controller
{
    public function __construct(protected RouteService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->service->getRoutes(),
            200
        );
    }
}
