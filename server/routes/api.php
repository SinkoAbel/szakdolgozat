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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/doctors', DoctorController::class);
    Route::apiResource('/admins', AdminController::class);


});
