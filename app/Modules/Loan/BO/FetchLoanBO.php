<?php

namespace App\Modules\Loan\BO;

final readonly class FetchLoanBO
{
    public function __construct(
        public ?string $loanNo = null,
        public ?string $customerName = null,
        public ?string $mobile = null,
        public ?string $status = null,
        public readonly ?int $assignedTo = null,
    ) {}
}