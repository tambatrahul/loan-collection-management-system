<?php

namespace App\Modules\Dashboard\Jobs;

use App\Modules\Collection\Models\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

final class RefreshCollectionTimeAnalyticsJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        DB::transaction(function (): void {
            $dates = [
                now()->toDateString(),
                now()->subDay()->toDateString(),
            ];

            DB::table('collection_time_analytics')
                ->whereIn('analytics_date', $dates)
                ->delete();

            $rows = Collection::query()
                ->whereRaw('DATE(collected_at) IN (?, ?)', $dates)
                ->selectRaw('collected_by as user_id')
                ->selectRaw('DATE(collected_at) as analytics_date')
                ->selectRaw('FLOOR(HOUR(collected_at) / 2) * 2 as slot_start_hour')
                ->selectRaw('COUNT(*) as total_collections')
                ->selectRaw('SUM(amount_paid) as total_amount')
                ->groupBy(
                    'collected_by',
                    DB::raw('DATE(collected_at)'),
                    DB::raw('FLOOR(HOUR(collected_at) / 2) * 2')
                )
                ->get();

            if ($rows->isEmpty()) {
                return;
            }

            $now = now();

            $data = $rows->map(static function ($row) use ($now): array {
                return [
                    'user_id' => (int) $row->user_id,
                    'analytics_date' => $row->analytics_date,
                    'slot_start_hour' => (int) $row->slot_start_hour,
                    'total_collections' => (int) $row->total_collections,
                    'total_amount' => (float) $row->total_amount,
                    'last_refreshed_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->toArray();

            DB::table('collection_time_analytics')->insert($data);
        });
    }
}