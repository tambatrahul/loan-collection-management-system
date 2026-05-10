<?php



namespace App\Modules\Auth\Interfaces\Services;

use App\Modules\Auth\BO\LoginBO;
use App\Modules\Auth\Models\User;

interface AuthServiceInterface
{
    public function login(LoginBO $bo): array;

    public function logout(User $user): void;

    public function me(User $user): User;
}