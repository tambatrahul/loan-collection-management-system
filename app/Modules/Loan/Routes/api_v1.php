<?php



use App\Modules\Loan\Http\Controllers\Api\V1\LoanController;
use Illuminate\Support\Facades\Route;

Route::prefix('loans')
    ->middleware('auth:sanctum')
    ->group(function (): void {
        // Admin + Agent
        Route::get('/', [LoanController::class, 'index'])
            ->middleware('role:admin,agent');

        Route::get('/{id}', [LoanController::class, 'show'])
            ->middleware('role:admin,agent');

        // Admin only
        Route::post('/', [LoanController::class, 'store'])
            ->middleware('role:admin,agent');

        Route::put('/{id}', [LoanController::class, 'update'])
            ->middleware('role:admin');

        Route::delete('/{id}', [LoanController::class, 'destroy'])
            ->middleware('role:admin');
    });