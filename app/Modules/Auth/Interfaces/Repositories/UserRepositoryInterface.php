<?php



namespace App\Modules\Auth\Interfaces\Repositories;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function getAgents(): Collection;
}