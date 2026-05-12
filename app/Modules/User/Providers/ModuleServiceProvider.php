<?php

namespace App\Modules\User\Providers;

use App\Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use App\Modules\User\Interfaces\Services\UserServiceInterface;
use App\Modules\User\Repositories\V1\UserRepository;
use App\Modules\User\Services\V1\UserService;
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
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(UserServiceInterface::class,UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
