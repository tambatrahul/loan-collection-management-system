<?php

namespace App\Modules\Collection\BO;

final readonly class FetchCollectionBO
{
    public function __construct(
        public ?int $loanId = null,
        public ?string $paymentMode = null,
        public readonly ?int $collectedBy = null,
    ) {}
}