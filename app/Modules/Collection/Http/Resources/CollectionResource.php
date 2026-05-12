<?php

namespace App\Modules\Collection\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'loan' => [
                'id' => $this->loan->id,
                'loan_no' => $this->loan->loan_no,
                'customer_name' => $this->loan->customer->name
            ],
            'amount_paid' => $this->amount_paid,
            'payment_mode' => $this->payment_mode,
            'location' => $this->location,
            'collected_at' => $this->collected_at?->toDateTimeString(),
            'collector' => [
                'id' => $this->collector->id,
                'name' => $this->collector->name,
            ],
        ];
    }
}