<?php

namespace App\Modules\Loan\Repositories\V1;

use App\Modules\Loan\BO\CreateLoanBO;
use App\Modules\Loan\BO\FetchLoanBO;
use App\Modules\Loan\BO\UpdateLoanBO;
use App\Modules\Loan\Interfaces\Repositories\LoanRepositoryInterface;
use App\Modules\Loan\Models\Loan;
use Illuminate\Pagination\LengthAwarePaginator;

final class LoanRepository implements LoanRepositoryInterface
{
    public function create(CreateLoanBO $bo): Loan
    {
        return Loan::query()->create([
            'loan_no' => $bo->loanNo,
            'customer_id' => $bo->customerId,
            'emi_amount' => $bo->emiAmount,
            'total_amount' => $bo->totalAmount,
            'created_by' => $bo->createdBy,
        ]);
    }

    public function getTodayLoanCount(): int
    {
        return Loan::query()
            ->whereDate('created_at', today())
            ->count();
    }

    // LoanRepository.php
    public function paginate(FetchLoanBO $bo, int $perPage): LengthAwarePaginator
    {
        return Loan::query()
            ->with('customer')
            ->withSum('collections', 'amount_paid')
            ->when(
                $bo->assignedTo !== null,
                fn($q) => $q->whereHas(
                    'customer',
                    fn($sub) => $sub->where('assigned_to', $bo->assignedTo)
                )
            )
            ->when(
                $bo->loanNo,
                fn($q) => $q->where('loan_no', 'like', "%{$bo->loanNo}%")
            )
            ->when(
                $bo->status,
                fn($q) => $q->where('status', $bo->status)
            )
            ->when($bo->customerName, function ($q) use ($bo) {
                $q->whereHas('customer', function ($sub) use ($bo) {
                    $sub->where('name', 'like', "%{$bo->customerName}%");
                });
            })
            ->when($bo->mobile, function ($q) use ($bo) {
                $q->whereHas('customer', function ($sub) use ($bo) {
                    $sub->where('mobile', 'like', "%{$bo->mobile}%");
                });
            })
            ->latest('id')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Loan
    {
        return Loan::query()
            ->with('customer')
            ->withSum('collections', 'amount_paid')
            ->findOrFail($id);
    }

    public function update(Loan $loan, UpdateLoanBO $bo): Loan
    {
        $loan->update([
            'customer_id' => $bo->customerId,
            'emi_amount' => $bo->emiAmount,
            'total_amount' => $bo->totalAmount,
            'status' => $bo->status,
        ]);

        return $loan->refresh();
    }

    public function delete(Loan $loan): void
    {
        $loan->delete();
    }
}
