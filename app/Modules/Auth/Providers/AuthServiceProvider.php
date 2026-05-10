<?php



namespace App\Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Auth\Providers\RouteServiceProvider;
use App\Modules\Auth\Providers\ModuleServiceProvider;


final class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register module service providers.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ModuleServiceProvider::class);
    }

    /**
     * Bootstrap module services.
     */
    public function boot(): void
    {
        //
    }
}