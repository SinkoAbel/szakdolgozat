<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\RouteController;
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

Route::apiResource('/patient/register', PatientController::class)->only(['store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/routes', RouteController::class)->only(['index']);

    Route::group(['middleware' => ['role:patient']], function () {
        Route::apiResource('/users', PatientController::class)->only(['show', 'update', 'destroy']);
    });

    Route::group(['middleware' => ['role:doctor']], function () {
        Route::apiResource('/doctors', DoctorController::class)->only(['index', 'update']);
    });

    Route::group(['middleware' => ['role:admins'], 'prefix' => 'admins'], function () {
        Route::apiResource('/users', PatientController::class)->only(['index', 'show', 'destroy']);

        Route::prefix('doctors')->group(function () {
            Route::apiResource('/', DoctorController::class)->only(['index', 'show', 'store', 'destroy']);
            Route::apiResource('/register', DoctorController::class)->only(['store']);
        });

        Route::apiResource('/', AdminController::class);
    });
});
