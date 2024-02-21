<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
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

Route::apiResource('/routes', RouteController::class)->only(['index']);
// Register user is a public function
Route::apiResource('/users/register', UserController::class)->only(['store']);

Route::group(['middleware' => ['auth:users']], function () {
    Route::apiResource('/users', UserController::class)->only(['show', 'update', 'destroy']);
});

Route::group(['middleware' => ['auth:doctors']], function () {
    Route::apiResource('/doctors', DoctorController::class)->only(['index', 'update']);
});

Route::group(['middleware' => ['auth:admins'], 'prefix' => 'admins'], function () {
    Route::apiResource('/users', UserController::class)->only(['index', 'show', 'destroy']);

    Route::prefix('doctors')->group(function () {
        Route::apiResource('/', DoctorController::class)->only(['index', 'show', 'store', 'destroy']);
        Route::apiResource('/register', DoctorController::class)->only(['store']);
    });

    Route::apiResource('/', AdminController::class);
});
