<?php

namespace App\Modules\Collection\Providers;

use App\Modules\Collection\Interfaces\Repositories\CollectionRepositoryInterface;
use App\Modules\Collection\Interfaces\Services\CollectionServiceInterface;
use App\Modules\Collection\Repositories\V1\CollectionRepository;
use App\Modules\Collection\Services\V1\CollectionService;
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
        $this->app->bind(CollectionRepositoryInterface::class,CollectionRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(CollectionServiceInterface::class,CollectionService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
