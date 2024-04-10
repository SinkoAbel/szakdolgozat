<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Every User
 *
 * APIs for every user of the system.
 */
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
     * GET - every user of the system if role filter not provided.
     *
     * @authenticated
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param Request $request
     * @return JsonResponse
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

    /**
     * GET - a user of the system.
     * Regardless of user role.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(
            new $this->resource(
                $user
            )
        );
    }
}
