<?php



namespace App\Modules\Customer\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap routes.
     */
    public function boot(): void
    {
        Route::prefix('api/v1')
            ->middleware('api')
            ->group(base_path('app/Modules/Customer/Routes/api_v1.php'));
    }
}