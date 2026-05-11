<?php

namespace App\Modules\Dashboard\Services\V1;

use App\Modules\Auth\Models\User;
use App\Modules\Dashboard\Interfaces\Repositories\DashboardRepositoryInterface;
use App\Modules\Dashboard\Interfaces\Services\DashboardServiceInterface;

final class DashboardService implements DashboardServiceInterface
{
    public function __construct(
        private readonly DashboardRepositoryInterface $dashboardRepository,
    ) {}

    public function getSummary(User $user): array
    {
        $userId = $user->role->name === 'ADMIN' ? null : $user->id;

        $totalLoans = $this->dashboardRepository->countLoans($userId);
        $totalCollectedToday = $this->dashboardRepository->sumCollectedToday($userId);
        $totalLoanAmount = $this->dashboardRepository->sumTotalLoanAmount($userId);
        $totalCollected = $this->dashboardRepository->sumTotalCollected($userId);
        $paymentModes = $this->dashboardRepository->getCollectionByPaymentMode($userId);

        return [
            'total_loans' => (int) $totalLoans,
            'total_collected_today' => (float) $totalCollectedToday,
            'pending_amount' => max((float) ($totalLoanAmount - $totalCollected), 0),
            'collection_by_payment_mode' => [
                'cash' => (float) ($paymentModes['cash'] ?? 0),
                'upi' => (float) ($paymentModes['upi'] ?? 0),
                'card' => (float) ($paymentModes['card'] ?? 0),
            ],
        ];
    }

    public function getBestCollectionTime(User $user): array
    {
        $userId = $user->role->name === 'ADMIN' ? null : $user->id;

        $row = $this->dashboardRepository->getBestCollectionTime($userId);

        if (! $row) {
            return [
                'best_time_slot' => null,
                'total_collections' => 0,
                'total_amount' => 0,
                'analysis_period' => 'Last 30 days',
            ];
        }

        $start = (int) $row->slot_start;
        $end = $start + 2;

        return [
            'best_time_slot' => sprintf('%02d:00 - %02d:00', $start, $end),
            'slot_start_hour' => $start,
            'slot_end_hour' => $end,
            'total_collections' => (int) $row->total_collections,
            'total_amount' => (float) $row->total_amount,
            'analysis_period' => 'Last 30 days',
        ];
    }
}
