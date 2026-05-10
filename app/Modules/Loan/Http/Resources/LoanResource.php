<?php



namespace App\Modules\Loan\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class LoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'loan_no' => $this->loan_no,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'mobile' => $this->customer->mobile,
                'address' => $this->customer->address,
            ],
            'emi_amount' => $this->emi_amount,
            'total_amount' => $this->total_amount,
            'collected_amount' => $this->collected_amount,
            'pending_amount' => $this->pending_amount,
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}