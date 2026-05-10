<?php



namespace App\Modules\Customer\Providers;

use App\Modules\Customer\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Modules\Customer\Interfaces\Services\CustomerServiceInterface;
use App\Modules\Customer\Repositories\V1\CustomerRepository;
use App\Modules\Customer\Services\V1\CustomerService;
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
        $this->app->bind(CustomerRepositoryInterface::class,CustomerRepository::class);
    }

    /**
     * Register service bindings.
     */
    private function registerServices(): void
    {
        $this->app->bind(CustomerServiceInterface::class,CustomerService::class);
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
