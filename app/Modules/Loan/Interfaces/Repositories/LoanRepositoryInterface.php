<?php

namespace App\Modules\Loan\Interfaces\Repositories;

use App\Modules\Loan\BO\CreateLoanBO;
use App\Modules\Loan\BO\FetchLoanBO;
use App\Modules\Loan\BO\UpdateLoanBO;
use App\Modules\Loan\Models\Loan;
use Illuminate\Pagination\LengthAwarePaginator;

interface LoanRepositoryInterface
{
    public function create(CreateLoanBO $bo): Loan;

    public function paginate(FetchLoanBO $bo, int $perPage): LengthAwarePaginator;

    public function findOrFail(int $id): Loan;

    public function update(Loan $loan, UpdateLoanBO $bo): Loan;

    public function delete(Loan $loan): void;
}