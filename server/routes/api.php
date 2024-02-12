<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//
// ---------------------------- User auth routes -----------------------------
Route::post('v1/auth/users/login', [UserAuthController::class, 'login']);
Route::post('v1/auth/users/register', [UserAuthController::class, 'register']);
Route::post('v1/auth/users/logout', [UserAuthController::class, 'logout'])
    ->middleware(['auth:sanctum']);
// ---------------------------------------------------------------------------

Route::apiResource('/users', UserController::class);
Route::apiResource('/doctors', DoctorController::class);
Route::apiResource('/admins', AdminController::class);
