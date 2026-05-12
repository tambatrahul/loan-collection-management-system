<?php

namespace App\Modules\User\BO;

final class CreateUserBO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $role,
    ) {}
}