<?php

namespace App\Modules\Auth\Providers;

use App\Modules\Auth\Interfaces\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Interfaces\Services\AuthServiceInterface;
use App\Modules\Auth\Interfaces\Repositories\UserRepositoryInterface;
use App\Modules\Auth\Interfaces\Services\UserServiceInterface;
use App\Modules\Auth\Repositories\V1\Auth\AuthRepository;
use App\Modules\Auth\Repositories\V1\User\UserRepository;
use App\Modules\Auth\Services\V1\Auth\AuthService;
use App\Modules\Auth\Services\V1\User\UserService;
use Illuminate\Support\ServiceProvider;

final class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register all repository and service bindings
     * for the Auth module.
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
        $this->app->bind(AuthRepositoryInterface::class,AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(AuthServiceInterface::class,AuthService::class);
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
