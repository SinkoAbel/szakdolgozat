<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookableReceptionTimesController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\ReservedBookingsController;
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
 * Admin role abilities:
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
 * 2. Doctor role abilities
 *      - Get One Doctor (Him-/Herself)
 *      - Update Doctor (Him-/Herself)
 *      - Can set free appointments
 *      - Can revoke it
 *      - Can see all of his/her appointments
 *
 * 3. Patient role abilities
 *      - Get One Patient (Him-/Herself)
 *      - Update One Patient (Him-/Herself)
 *      - Can book free appointments
 */
Route::post('/patient/register', [PatientController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/routes', RouteController::class)->only(['index']);

    // TODO: Admin can do everything with everyone?
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('super')->group(function () {
            Route::apiResource('/admins', AdminController::class);
            Route::apiResource('/doctors', DoctorController::class)->only(['index', 'store', 'destroy']);
            Route::apiResource('/patients', PatientController::class)->only(['index', 'destroy']);
        });
    });

    Route::group(['middleware' => ['role:doctor|admin']], function () {
        Route::prefix('/doctors')->group(function ()  {
            Route::apiResource('/', DoctorController::class)->only(['show', 'update']);
            Route::apiResource('/appointments', BookableReceptionTimesController::class);
        });
    });

    Route::group(['middleware' => ['role:patient|admin']], function () {
        Route::prefix('patients')->group(function () {
            Route::apiResource('/', PatientController::class)->only(['show', 'update']);
            Route::apiResource('/bookings', ReservedBookingsController::class)->only(['index', 'show', 'store']);
        });
    });
});
