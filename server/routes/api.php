<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
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

/**
 * TODO:
 * 1. admin abilities:
 *      - Get Admins
 *      - Get One Admin
 *      - Create Admin
 *      - Update Admin
 *      - Delete Admin
 *
 *      - Get Doctors
 *      - Get One Doctor
 *      - Create Doctor
 *      - Delete Doctor
 *      - Update Doctor
 *
 *      - Get Users
 *      - Get User
 *      - Delete User
 *
 * 2. Doctor abilities
 *      - Get One Doctor (Him-/Herself)
 *      - Update Doctor (Him-/Herself)
 *      - Can set free appointments
 *      - Can revoke it
 *      - Can see all of his/her appointments
 *
 * 3. Patient abilities
 *      - Get One Patient (Him-/Herself)
 *      - Update One Patient (Him-/Herself)
 *      - Can book free appointments
 */

Route::apiResource('/patient/register', PatientController::class)->only(['store']);
Route::post('/login', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthController::class, 'destroy']); // TODO: is it really needed?

    Route::apiResource('/routes', RouteController::class)->only(['index']);

    Route::group(['middleware' => ['role:admin', 'role:patient']], function () {
        Route::apiResource('/patients', PatientController::class)->only(['show', 'update']);
    });

    Route::group(['middleware' => ['role:admin', 'role:doctor']], function () {
        Route::apiResource('/doctor', DoctorController::class)->only(['show', 'update']);
    });

    // TODO: Admin can do everything with everyone?
    Route::group(['middleware' => ['role:admin']], function () {
        Route::apiResource('/admins', AdminController::class);
        Route::apiResource('/doctors', DoctorController::class)->only(['index', 'store', 'destroy']);
        Route::apiResource('/patients', PatientController::class)->only(['index', 'destroy']);
    });

    Route::group(['middleware' => ['role:doctor']], function () {

    });

    Route::group(['middleware' => ['role:patient']], function () {

    });
});
