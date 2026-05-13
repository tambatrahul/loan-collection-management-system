<?php

use App\Modules\User\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    'role:admin,agent',
])->group(function (): void {
    Route::apiResource('users', UserController::class);
});