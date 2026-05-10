<?php

namespace App\Modules\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Dashboard\Providers\RouteServiceProvider;
use App\Modules\Dashboard\Providers\ModuleServiceProvider;


final class DashboardServiceProvider extends ServiceProvider
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