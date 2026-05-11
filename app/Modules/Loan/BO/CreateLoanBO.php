<?php

namespace App\Modules\Loan\BO;

final readonly class CreateLoanBO
{
    public function __construct(
        public string $loanNo,
        public int $customerId,
        public float $emiAmount,
        public float $totalAmount,
        public int $createdBy,
    ) {}
}