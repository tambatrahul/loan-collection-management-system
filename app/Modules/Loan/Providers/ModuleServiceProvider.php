<?php

namespace App\Modules\Loan\Providers;

use App\Modules\Loan\Interfaces\Repositories\LoanRepositoryInterface;
use App\Modules\Loan\Interfaces\Services\LoanServiceInterface;
use App\Modules\Loan\Repositories\V1\LoanRepository;
use App\Modules\Loan\Services\V1\LoanService;
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
        $this->app->bind(LoanRepositoryInterface::class,LoanRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(LoanServiceInterface::class, LoanService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
