<?php

use App\Http\Controllers\api\JobController;
use App\Http\Controllers\api\OrganizationController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/organizations', OrganizationController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

Route::apiResource('/jobs', JobController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');

Route::apiResource('/user', UserController::class)
    ->middlewareFor(['store', 'update', 'destroy'], 'auth:sanctum');
