<?php

use App\Modules\Collection\Http\Controllers\Api\V1\CollectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('collections')
    ->middleware('auth:sanctum')
    ->group(function (): void {
        Route::get('/', [CollectionController::class, 'index'])
            ->middleware('role:admin,agent');
        Route::post('/', [CollectionController::class, 'store'])
            ->middleware('role:admin,agent');
        Route::get('/{id}', [CollectionController::class, 'show'])
            ->middleware('role:admin,agent');
    });