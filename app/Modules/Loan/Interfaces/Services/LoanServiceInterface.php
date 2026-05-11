<?php

namespace App\Modules\Loan\Interfaces\Services;

use App\Modules\Loan\BO\CreateLoanBO;
use App\Modules\Loan\BO\FetchLoanBO;
use App\Modules\Loan\BO\UpdateLoanBO;
use App\Modules\Loan\Models\Loan;
use Illuminate\Pagination\LengthAwarePaginator;

interface LoanServiceInterface
{
    public function create(CreateLoanBO $bo): Loan;

    public function paginate(FetchLoanBO $bo, int $perPage): LengthAwarePaginator;

    public function find(int $id): Loan;

    public function update(int $id, UpdateLoanBO $bo): Loan;

    public function delete(int $id): void;
}