<?php

namespace App\Modules\Dashboard\Interfaces\Services;

use App\Modules\Auth\Models\User;

interface DashboardServiceInterface
{
    public function getSummary(User $user): array;

    public function getBestCollectionTime(User $user): array;
}