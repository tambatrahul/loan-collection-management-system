<?php



namespace App\Modules\Auth\BO;

final readonly class LoginBO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}