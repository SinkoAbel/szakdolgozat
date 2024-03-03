<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AdminService;
use App\Services\DoctorService;
use App\Services\PatientService;

class AuthController extends Controller
{
    public function __construct(
        protected PatientService $userService,
        protected DoctorService  $doctorService,
        protected AdminService   $adminService
    )
    {
    }

    public function login(LoginRequest $request)
    {
        // TODO: implement login for all roles
    }
}
