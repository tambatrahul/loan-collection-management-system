<?php

namespace App\Modules\Customer\BO;

final readonly class UpdateCustomerBO
{
    public function __construct(
        public string $name,
        public string $mobile,
        public string $address,
    ) {}
}