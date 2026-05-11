<?php

namespace App\Modules\Dashboard\Interfaces\Repositories;

interface DashboardRepositoryInterface
{
    public function countLoans(?int $userId = null): int;

    public function sumCollectedToday(?int $userId = null): float;

    public function sumTotalLoanAmount(?int $userId = null): float;

    public function sumTotalCollected(?int $userId = null): float;

    public function getCollectionByPaymentMode(?int $userId = null): array;

    public function getBestCollectionTime(?int $userId = null): ?object;
}