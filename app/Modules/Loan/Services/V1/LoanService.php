<?php

namespace App\Modules\Loan\Services\V1;

use App\Modules\Loan\BO\CreateLoanBO;
use App\Modules\Loan\BO\FetchLoanBO;
use App\Modules\Loan\BO\UpdateLoanBO;
use App\Modules\Loan\Interfaces\Repositories\LoanRepositoryInterface;
use App\Modules\Loan\Interfaces\Services\LoanServiceInterface;
use App\Modules\Loan\Models\Loan;
use Illuminate\Pagination\LengthAwarePaginator;

final class LoanService implements LoanServiceInterface
{
    public function __construct(
        private readonly LoanRepositoryInterface $loanRepository,
    ) {}

    public function create(CreateLoanBO $bo): Loan
    {
        $count = $this->loanRepository->getTodayLoanCount() + 1;

        $bo->loanNo = sprintf(
            'LN-%s-%04d',
            now()->format('Ymd'),
            $count
        );

        return $this->loanRepository->create($bo);
    }

    public function paginate(FetchLoanBO $bo, int $perPage): LengthAwarePaginator
    {
        return $this->loanRepository->paginate($bo, $perPage);
    }

    public function find(int $id): Loan
    {
        return $this->loanRepository->findOrFail($id);
    }

    public function update(int $id, UpdateLoanBO $bo): Loan
    {
        $loan = $this->loanRepository->findOrFail($id);

        return $this->loanRepository->update($loan, $bo);
    }

    public function delete(int $id): void
    {
        $loan = $this->loanRepository->findOrFail($id);

        $this->loanRepository->delete($loan);
    }
}
