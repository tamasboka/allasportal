<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\JobApplicationController;
use App\Http\Controllers\api\JobController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\api\OrganizationController;
use App\Http\Controllers\api\RatingController;
use App\Http\Controllers\api\SkillController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// Roles
Route::post('/roles', [AuthController::class, 'abilities'])
    ->middleware('auth:sanctum');

// Organizations
Route::apiResource('/organizations', OrganizationController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

// Jobs
Route::apiResource('/jobs', JobController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

// User
Route::apiResource('/user', UserController::class)
    ->middlewareFor(['index', 'update', 'destroy'], 'auth:sanctum');

// Applications
Route::apiResource('/applications', JobApplicationController::class)
    ->middleware('auth:sanctum');

// Notifications, ratings
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('ratings', RatingController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('categories', CategoryController::class);
});
