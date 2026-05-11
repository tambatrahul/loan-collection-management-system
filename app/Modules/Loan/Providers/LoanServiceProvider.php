<?php

namespace App\Modules\Loan\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Loan\Providers\RouteServiceProvider;
use App\Modules\Loan\Providers\ModuleServiceProvider;

final class LoanServiceProvider extends ServiceProvider
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