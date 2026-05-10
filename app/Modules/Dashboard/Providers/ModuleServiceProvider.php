<?php

namespace App\Modules\Dashboard\Providers;

use App\Modules\Dashboard\Interfaces\Repositories\DashboardRepositoryInterface;
use App\Modules\Dashboard\Interfaces\Services\DashboardServiceInterface;
use App\Modules\Dashboard\Repositories\V1\DashboardRepository;
use App\Modules\Dashboard\Services\V1\DashboardService;
use Illuminate\Support\ServiceProvider;

final class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Register repository bindings.
     */
    private function registerRepositories(): void
    {
        $this->app->bind(DashboardRepositoryInterface::class,DashboardRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(DashboardServiceInterface::class,DashboardService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
