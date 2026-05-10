<?php

namespace App\Modules\Auth\Interfaces\Services;

use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function getAgents(): Collection;
}