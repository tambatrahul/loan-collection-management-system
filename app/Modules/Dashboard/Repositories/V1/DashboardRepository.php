<?php

namespace App\Modules\Dashboard\Repositories\V1;

use App\Modules\Collection\Models\Collection;
use App\Modules\Dashboard\Interfaces\Repositories\DashboardRepositoryInterface;
use App\Modules\Dashboard\Models\CollectionTimeAnalytics;
use App\Modules\Loan\Models\Loan;
use Illuminate\Support\Facades\DB;

final class DashboardRepository implements DashboardRepositoryInterface
{
    public function countLoans(?int $userId = null): int
    {
        return Loan::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->whereHas(
                    'customer',
                    fn ($customerQuery) => $customerQuery->where(
                        'assigned_to',
                        $userId
                    )
                )
            )
            ->count();
    }

    public function sumCollectedToday(?int $userId = null): float
    {
        return (float) Collection::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->whereHas(
                    'loan.customer',
                    fn ($customerQuery) => $customerQuery->where(
                        'assigned_to',
                        $userId
                    )
                )
            )
            ->whereDate('collected_at', today())
            ->sum('amount_paid');
    }

    public function sumTotalLoanAmount(?int $userId = null): float
    {
        return (float) Loan::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->whereHas(
                    'customer',
                    fn ($customerQuery) => $customerQuery->where(
                        'assigned_to',
                        $userId
                    )
                )
            )
            ->sum('total_amount');
    }

    public function sumTotalCollected(?int $userId = null): float
    {
        return (float) Collection::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->whereHas(
                    'loan.customer',
                    fn ($customerQuery) => $customerQuery->where(
                        'assigned_to',
                        $userId
                    )
                )
            )
            ->sum('amount_paid');
    }

    public function getCollectionByPaymentMode(?int $userId = null): array
    {
        return Collection::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->whereHas(
                    'loan.customer',
                    fn ($customerQuery) => $customerQuery->where(
                        'assigned_to',
                        $userId
                    )
                )
            )
            ->select('payment_mode', DB::raw('SUM(amount_paid) as total_amount'))
            ->groupBy('payment_mode')
            ->pluck('total_amount', 'payment_mode')
            ->toArray();
    }

    public function getBestCollectionTime(?int $userId = null): ?object
    {
        return CollectionTimeAnalytics::query()
            ->when(
                $userId !== null,
                fn ($query) => $query->where('user_id', $userId)
            )
            ->where(
                'analytics_date',
                '>=',
                now()->subDays(30)->toDateString()
            )
            ->selectRaw('slot_start_hour as slot_start')
            ->selectRaw('SUM(total_collections) as total_collections')
            ->selectRaw('SUM(total_amount) as total_amount')
            ->groupBy('slot_start_hour')
            ->orderByDesc('total_collections')
            ->orderByDesc('total_amount')
            ->first();
    }
}