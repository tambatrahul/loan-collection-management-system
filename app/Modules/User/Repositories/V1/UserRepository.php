<?php

namespace App\Modules\User\Repositories\V1;

use App\Modules\Auth\Models\User;
use App\Modules\User\BO\CreateUserBO;
use App\Modules\User\BO\FetchUserBO;
use App\Modules\User\BO\UpdateUserBO;
use App\Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

final class UserRepository implements UserRepositoryInterface
{
    public function create(CreateUserBO $bo): User
    {
        return User::query()->create([
            'name' => $bo->name,
            'email' => $bo->email,
            'password' => Hash::make($bo->password),
            'role' => $bo->role,
        ]);
    }
    public function paginate(FetchUserBO $bo, int $perPage): LengthAwarePaginator
    {
        $query = User::query()->latest();

        $this->applyFilters($query, $bo);

        return $query->paginate($perPage);
    }

    public function findOrFail(int $id): User
    {
        return User::query()->findOrFail($id);
    }

    public function update(User $user, UpdateUserBO $bo): User
    {
        $data = [
            'name' => $bo->name,
            'email' => $bo->email,
            'role' => $bo->role,
        ];

        if ($bo->password) {
            $data['password'] = Hash::make($bo->password);
        }

        $user->update($data);

        return $user->fresh();
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    private function applyFilters(Builder $query, FetchUserBO $bo): void
    {
        if ($bo->name) {
            $query->where('name', 'like', "%{$bo->name}%");
        }

        if ($bo->email) {
            $query->where('email', 'like', "%{$bo->email}%");
        }

        if ($bo->role) {
            $query->where('role', $bo->role);
        }
    }
}