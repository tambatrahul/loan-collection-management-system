<?php

namespace App\Modules\Auth\Services\V1\User;

use App\Modules\Auth\Interfaces\Services\UserServiceInterface;
use App\Modules\Auth\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function getAgents(): Collection
    {
        return $this->userRepository->getAgents();
    }
}