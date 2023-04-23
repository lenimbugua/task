<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\StatsController;
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

    Route::post('/user-task', [UserTaskController::class, 'store']);
    Route::put('/user-task/update/{id}', [UserTaskController::class, 'update']);
    Route::put('/user-task/start', [UserTaskController::class, 'startTask']);
    Route::put('/user-task/end', [UserTaskController::class, 'endTask']);
    Route::get('/user-task/{user_id}', [UserTaskController::class, 'listUserTasks']);
    Route::delete('/user-task/{id}', [UserTaskController::class, 'destroy']);

    Route::get('/count-user-tasks', [StatsController::class, 'countUserTasks']);
    Route::get('/count-users', [StatsController::class, 'countUsers']);
    Route::get('/count-user-task-status/{name}', [StatsController::class, 'countStatus']);

    Route::get('/count-expired-user-tasks/', [StatsController::class, 'countExpiredUserTasks']);
    Route::get('/count-expired-user-tasks-days/{days}', [StatsController::class, 'countPastExpiredUserTasks']);




    // Route::post('/logout', [AuthController::class, 'logout']);
});
