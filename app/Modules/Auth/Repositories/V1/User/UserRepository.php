<?php

namespace App\Modules\Auth\Repositories\V1\User;

use App\Modules\Auth\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    public function getAgents(): Collection
    {
        return User::query()
            ->where('role', 'agent')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
    }
}