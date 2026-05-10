<?php

namespace App\Modules\Collection\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Collection\Providers\RouteServiceProvider;
use App\Modules\Collection\Providers\ModuleServiceProvider;

final class CollectionServiceProvider extends ServiceProvider
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