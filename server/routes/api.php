<?php

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

// User interface routes
// TODO: add auth for user routes
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// Doctor auth routes
// TODO: add auth for doctor auth routes
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// Doctor interface routes
// TODO: add auth for doctor routes
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// Admin auth routes
// TODO: add auth for admin auth routes
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------

// Admin routes
// TODO: add auth for admin routes
// ---------------------------------------------------------------------------
Route::get('/v1/users', [UserController::class, 'index']);
Route::get('/v1/users/{id}', [UserController::class, 'getUser']);
// ---------------------------------------------------------------------------
