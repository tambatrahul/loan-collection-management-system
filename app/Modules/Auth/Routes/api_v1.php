<?php

use App\Modules\Auth\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Http\Controllers\Api\V1\AuthController;

Route::prefix('auth')->group(function (): void {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});
