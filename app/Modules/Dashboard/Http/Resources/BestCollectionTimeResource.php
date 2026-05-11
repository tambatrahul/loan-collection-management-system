<?php

namespace App\Modules\Dashboard\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class BestCollectionTimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'best_time_slot' => $this['best_time_slot'],
            'slot_start_hour' => $this['slot_start_hour'] ?? null,
            'slot_end_hour' => $this['slot_end_hour'] ?? null,
            'total_collections' => $this['total_collections'],
            'total_amount' => $this['total_amount'],
            'analysis_period' => $this['analysis_period'],
        ];
    }
}