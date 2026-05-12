<?php

namespace App\Modules\User\Interfaces\Services;

use App\Modules\Auth\Models\User;
use App\Modules\User\BO\CreateUserBO;
use App\Modules\User\BO\FetchUserBO;
use App\Modules\User\BO\UpdateUserBO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function create(CreateUserBO $bo): User;

    public function paginate(FetchUserBO $bo, int $perPage): LengthAwarePaginator;

    public function find(int $id): User;

    public function update(int $id, UpdateUserBO $bo): User;

    public function delete(int $id): void;
}