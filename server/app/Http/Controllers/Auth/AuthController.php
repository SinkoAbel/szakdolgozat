<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->login($request),
            200
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revoked.'
        ], 200);
    }
}
