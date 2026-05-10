<?php

namespace App\Modules\Auth\Services\V1\Auth;

use App\Modules\Auth\BO\LoginBO;
use App\Modules\Auth\Interfaces\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Interfaces\Services\AuthServiceInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

final class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly AuthRepositoryInterface $authRepository,
    ) {}

    public function login(LoginBO $bo): array
    {
        $user = $this->authRepository->findByEmail($bo->email);

        if (! $user || ! Hash::check($bo->password, $user->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials.');
        }

        $token = $this->authRepository->createToken($user, 'auth-token');

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $this->authRepository->revokeCurrentToken($user);
    }

    public function me(User $user): User
    {
        return $user;
    }
}