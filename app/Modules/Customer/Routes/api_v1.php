<?php

use App\Modules\Customer\Http\Controllers\Api\V1\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')
    ->middleware('auth:sanctum')
    ->group(function (): void {
        Route::get('/', [CustomerController::class, 'index'])
            ->middleware('role:admin,agent');

        Route::get('/{id}', [CustomerController::class, 'show'])
            ->middleware('role:admin,agent');

        Route::post('/', [CustomerController::class, 'store'])
            ->middleware('role:admin,agent');

        Route::put('/{id}', [CustomerController::class, 'update'])
            ->middleware('role:admin');

        Route::delete('/{id}', [CustomerController::class, 'destroy'])
            ->middleware('role:admin');
    });