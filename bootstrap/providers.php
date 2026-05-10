<?php

use App\Modules\Auth\Providers\AuthServiceProvider;
use App\Modules\Customer\Providers\CustomerServiceProvider;
use App\Modules\Loan\Providers\LoanServiceProvider;
use App\Modules\Collection\Providers\CollectionServiceProvider;
use App\Modules\Dashboard\Providers\DashboardServiceProvider;

return [
    AuthServiceProvider::class,
    CustomerServiceProvider::class,
    LoanServiceProvider::class,
    CollectionServiceProvider::class,
    DashboardServiceProvider::class,
];
