<?php

namespace App\Modules\Auth\Repositories\V1\Auth;

use App\Modules\Auth\Interfaces\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Models\User;

final class AuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', $email)
            ->first();
    }

    public function createToken(User $user, string $tokenName = 'api-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function revokeCurrentToken(User $user): void
    {
        $token = $user->currentAccessToken();

        $token?->delete();
    }
}