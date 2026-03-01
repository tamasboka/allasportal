<?php

use App\Http\Controllers\api\JobController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('/jobs', JobController::class);

Route::apiResource('/user', UserController::class);
