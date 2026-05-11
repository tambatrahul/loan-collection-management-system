<?php

namespace App\Modules\Customer\BO;

final readonly class CreateCustomerBO
{
    public function __construct(
        public string $name,
        public string $mobile,
        public string $address,
        public int $assigned_to
    ) {}
}