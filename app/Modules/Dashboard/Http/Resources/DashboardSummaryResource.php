<?php

namespace App\Modules\Dashboard\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DashboardSummaryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_loans' => $this['total_loans'],
            'total_collected_today' => $this['total_collected_today'],
            'pending_amount' => $this['pending_amount'],
            'collection_by_payment_mode' => $this['collection_by_payment_mode'],
        ];
    }
}