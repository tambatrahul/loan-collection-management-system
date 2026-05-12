<?php

namespace App\Modules\Collection\Repositories\V1;

use App\Modules\Collection\BO\CreateCollectionBO;
use App\Modules\Collection\BO\FetchCollectionBO;
use App\Modules\Collection\Interfaces\Repositories\CollectionRepositoryInterface;
use App\Modules\Collection\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

final class CollectionRepository implements CollectionRepositoryInterface
{
    public function create(CreateCollectionBO $bo): Collection
    {
        return Collection::query()->create([
            'loan_id' => $bo->loanId,
            'amount_paid' => $bo->amountPaid,
            'payment_mode' => $bo->paymentMode,
            'location' => $bo->location,
            'collected_at' => $bo->collectedAt,
            'collected_by' => $bo->collectedBy,
        ]);
    }

    public function paginate(FetchCollectionBO $bo, int $perPage): LengthAwarePaginator
    {
        return Collection::query()
            ->with(['loan', 'loan.customer', 'collector'])
            ->when($bo->loanId, fn($q) => $q->where('loan_id', $bo->loanId))
            ->when($bo->paymentMode, fn($q) => $q->where('payment_mode', $bo->paymentMode))
            ->latest('collected_at')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Collection
    {
        return Collection::query()
            ->with(['loan', 'collector'])
            ->findOrFail($id);
    }

    public function update($collection, array $data)
    {
        $collection->update($data);

        return $collection->fresh();
    }

    public function delete($collection): void
    {
        $collection->delete();
    }
}
