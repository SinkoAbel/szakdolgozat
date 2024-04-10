<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Auth
 *
 * Authentication data.
 */
class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {
    }

    /**
     * Logout - handle the logout process.
     * Revokes the requester user's access token.
     *
     * @authenticated
     * @response status=200 {
     *     'message': 'Token revoked. User logged out.'
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revoked. User logged out.'
        ], 200);
    }
}
