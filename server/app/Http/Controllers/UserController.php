<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    protected string $model;
    protected string $resource;

    public function __construct()
    {
        $this->model = User::class;
        $this->resource = UserResource::class;
    }

    /**
     * This function returns every users
     * of the system. When provided it
     * filters for Role.
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/api/super/users",
     *      operationId="getEveryUsersOrByRole",
     *      security={{"bearer_token":{}}},
     *      tags={"Users by roles"},
     *      summary="Get every users. Can provider role filter.",
     *      description="Returns every users of the system.",
     *      @OA\Parameter(
     *          name="request",
     *          in="path",
     *          description="Request that could contain the filter.",
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Successfull request."
     *      ),
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $roleFilter = $request->filters['role'] ?? null;

        return response()->json(
            $this->resource::collection(
                $this->model::query()
                     ->when($roleFilter, function ($query) use($roleFilter) {
                         $query->role($roleFilter);
                     })
                     ->get()
            )
        );
    }

    public function show(User $user): JsonResponse
    {
        return response()->json(
            new $this->resource(
                $user
            )
        );
    }
}
