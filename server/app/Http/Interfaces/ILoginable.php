<?php

namespace App\Http\Interfaces;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

interface ILoginable
{
    public function login(LoginRequest $request): JsonResponse;
}

