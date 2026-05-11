<?php

namespace App\Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Customer\Providers\RouteServiceProvider;
use App\Modules\Customer\Providers\ModuleServiceProvider;

final class CustomerServiceProvider extends ServiceProvider
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