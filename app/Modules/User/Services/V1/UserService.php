<?php

namespace App\Modules\User\Services\V1;

use App\Modules\Auth\Models\User;
use App\Modules\User\BO\CreateUserBO;
use App\Modules\User\BO\FetchUserBO;
use App\Modules\User\BO\UpdateUserBO;
use App\Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use App\Modules\User\Interfaces\Services\UserServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function create(CreateUserBO $bo): User
    {
        return $this->userRepository->create($bo);
    }

    public function paginate(FetchUserBO $bo, int $perPage): LengthAwarePaginator
    {
        return $this->userRepository->paginate($bo, $perPage);
    }

    public function find(int $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function update(int $id, UpdateUserBO $bo): User
    {
        $user = $this->userRepository->findOrFail($id);

        return $this->userRepository->update($user, $bo);
    }

    public function delete(int $id): void
    {
        $user = $this->userRepository->findOrFail($id);

        $this->userRepository->delete($user);
    }
}