<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\JobApplicationController;
use App\Http\Controllers\api\JobController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\api\OrganizationController;
use App\Http\Controllers\api\RatingController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');
Route::post('/roles', [AuthController::class, 'abilities'])
    ->middleware('auth:sanctum');
Route::apiResource('/organizations', OrganizationController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

Route::apiResource('/jobs', JobController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

Route::apiResource('/user', UserController::class)
    ->middlewareFor(['index', 'update', 'destroy'], 'auth:sanctum');

Route::apiResource('/applications', JobApplicationController::class)
    ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('ratings', RatingController::class);
});
