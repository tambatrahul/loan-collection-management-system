<?php

namespace App\Modules\User\Interfaces\Repositories;

use App\Modules\Auth\Models\User;
use App\Modules\User\BO\CreateUserBO;
use App\Modules\User\BO\FetchUserBO;
use App\Modules\User\BO\UpdateUserBO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function create(CreateUserBO $bo): User;

    public function paginate(FetchUserBO $bo, int $perPage): LengthAwarePaginator;

    public function findOrFail(int $id): User;

    public function update(User $user, UpdateUserBO $bo): User;

    public function delete(User $user): void;
}