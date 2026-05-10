<?php

use App\Modules\Dashboard\Http\Controllers\Api\V1\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')
    ->middleware(['auth:sanctum', 'role:admin,agent'])
    ->group(function (): void {
        Route::get('/summary', [DashboardController::class, 'summary']);
        Route::get('/best-collection-time', [DashboardController::class, 'bestCollectionTime']);
    });