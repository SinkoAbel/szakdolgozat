<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected string $model;
    protected string $resource;
    protected array $eagerLoad;

    public function __construct()
    {
        $this->model = User::class;
        $this->resource = UserResource::class;
        $this->eagerLoad = [
            'roles' => function ($query) {
                $query->select(
                    '*'
                );
            }
        ];
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->resource::collection(
                $this->model::all()
            )
        );
    }
}
