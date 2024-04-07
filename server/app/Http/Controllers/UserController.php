<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected string $model;
    protected string $resource;

    public function __construct()
    {
        $this->model = User::class;
        $this->resource = UserResource::class;
    }

    public function index(Request $request): JsonResponse
    {
        $roleFilter = $request->filters['role'] ?? null;
        // TODO: implement filter
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
