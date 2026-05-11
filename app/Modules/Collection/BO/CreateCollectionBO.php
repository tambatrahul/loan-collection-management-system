<?php

namespace App\Modules\Collection\BO;

final readonly class CreateCollectionBO
{
    public function __construct(
        public int $loanId,
        public float $amountPaid,
        public string $paymentMode,
        public ?string $location,
        public string $collectedAt,
        public int $collectedBy,
    ) {}
}