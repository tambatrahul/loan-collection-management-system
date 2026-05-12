<?php

namespace App\Modules\Loan\BO;

final class CreateLoanBO
{
    public function __construct(
        public ?string $loanNo,
        public readonly int $customerId,
        public readonly float $emiAmount,
        public readonly float $totalAmount,
        public readonly int $createdBy,
    ) {}
}