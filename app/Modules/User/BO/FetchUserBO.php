<?php

namespace App\Modules\User\BO;

final class FetchUserBO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $role = null,
    ) {}
}