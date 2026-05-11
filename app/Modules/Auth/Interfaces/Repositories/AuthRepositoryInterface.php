<?php



namespace App\Modules\Auth\Interfaces\Repositories;

use App\Modules\Auth\Models\User;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function createToken(User $user, string $tokenName = 'api-token'): string;

    public function revokeCurrentToken(User $user): void;
}