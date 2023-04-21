<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/status', StatusController::class);
    Route::apiResource('/task', TaskController::class);

    Route::apiResource('/users', UserController::class);



    // Route::post('/logout', [AuthController::class, 'logout']);
});
