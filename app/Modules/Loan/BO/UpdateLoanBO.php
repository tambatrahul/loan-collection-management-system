<?php

namespace App\Modules\Loan\BO;

final readonly class UpdateLoanBO
{
    public function __construct(
        public int $customerId,
        public float $emiAmount,
        public float $totalAmount,
        public string $status,
    ) {}
}