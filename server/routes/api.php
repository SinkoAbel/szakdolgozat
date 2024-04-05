<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookableReceptionTimesController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\ReservedBookingsController;
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
Route::post('/patient/login', [PatientController::class, 'login']);
Route::post('/doctor/login', [DoctorController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/routes', RouteController::class)->only(['index']);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('super')->group(function () {
            Route::apiResource('/users', UserController::class)->only(['index']);
            Route::apiResource('/admins', AdminController::class);
            Route::apiResource('/doctors', DoctorController::class)->only(['store', 'destroy']);
            Route::apiResource('/patients', PatientController::class)->only(['index', 'destroy']);
        });
    });

    Route::group(['middleware' => ['role:doctor|patient|admin']], function () {
        Route::apiResource('/appointments', BookableReceptionTimesController::class)->only(['index']);
    });

    Route::group(['middleware' => ['role:doctor|admin']], function () {
        Route::prefix('/doctors')->group(function ()  {
            Route::get('/{doctor}', [DoctorController::class, 'show']);
            Route::put('/{doctor}', [DoctorController::class, 'update']);
        });

        Route::apiResource('/appointments', BookableReceptionTimesController::class)->only(['show', 'store', 'update', 'delete']);
    });

    Route::group(['middleware' => ['role:patient|admin']], function () {
        Route::apiResource('/list/doctors', DoctorController::class)->only(['index']);

        Route::prefix('patients')->group(function () {
            Route::get('/{patient}', [PatientController::class, 'show']);
            Route::put('/{patient}', [PatientController::class, 'update']);
        });

        Route::prefix('bookings')->group(function () {
            Route::get('/', [ReservedBookingsController::class, 'index']);
            Route::get('/{booking}', [ReservedBookingsController::class, 'show']);
            Route::post('/', [ReservedBookingsController::class, 'store']);
        });
    });
});
