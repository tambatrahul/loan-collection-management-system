<?php

namespace App\Modules\Collection\BO;

final class UpdateCollectionBO
{
    public function __construct(
        public readonly int $loanId,
        public readonly float $amountPaid,
        public readonly string $paymentMode,
        public readonly ?string $location,
        public readonly string $collectedAt,
        public readonly int $collectedBy,
    ) {}

    public function toArray(): array
    {
        return [
            'loan_id' => $this->loanId,
            'amount_paid' => $this->amountPaid,
            'payment_mode' => $this->paymentMode,
            'location' => $this->location,
            'collected_at' => $this->collectedAt,
            'collected_by' => $this->collectedBy,
        ];
    }
}