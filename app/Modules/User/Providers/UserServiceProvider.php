<?php

namespace App\Modules\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\User\Providers\RouteServiceProvider;
use App\Modules\User\Providers\ModuleServiceProvider;

final class UserServiceProvider extends ServiceProvider
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