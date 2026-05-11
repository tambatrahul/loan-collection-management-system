<?php

namespace App\Modules\Collection\Services\V1;

use App\Modules\Collection\BO\CreateCollectionBO;
use App\Modules\Collection\BO\FetchCollectionBO;
use App\Modules\Collection\BO\UpdateCollectionBO;
use App\Modules\Collection\Interfaces\Repositories\CollectionRepositoryInterface;
use App\Modules\Collection\Interfaces\Services\CollectionServiceInterface;
use App\Modules\Collection\Models\Collection;
use App\Modules\Loan\Interfaces\Repositories\LoanRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class CollectionService implements CollectionServiceInterface
{
    public function __construct(
        private readonly CollectionRepositoryInterface $collectionRepository,
        private readonly LoanRepositoryInterface $loanRepository,
    ) {}

    public function create(CreateCollectionBO $bo): Collection
    {
        $loan = $this->loanRepository->findOrFail($bo->loanId);

        if ($bo->amountPaid > $loan->pending_amount) {
            throw new UnprocessableEntityHttpException(
                'Amount paid cannot exceed pending amount.'
            );
        }

        return $this->collectionRepository->create($bo);
    }

    public function paginate(FetchCollectionBO $bo, int $perPage): LengthAwarePaginator
    {
        return $this->collectionRepository->paginate($bo, $perPage);
    }

    public function find(int $id): Collection
    {
        return $this->collectionRepository->findOrFail($id);
    }

    public function update(int $id, UpdateCollectionBO $bo): Collection {
        $collection = $this->collectionRepository->findOrFail($id);

        return $this->collectionRepository->update(
            $collection,
            $bo->toArray()
        );
    }

    public function delete(int $id): void
    {
        $collection = $this->collectionRepository->findOrFail($id);

        $this->collectionRepository->delete($collection);
    }
}
