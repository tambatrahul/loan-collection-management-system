<?php

namespace App\Modules\Collection\Interfaces\Repositories;

use App\Modules\Collection\BO\CreateCollectionBO;
use App\Modules\Collection\BO\FetchCollectionBO;
use App\Modules\Collection\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CollectionRepositoryInterface
{
    public function create(CreateCollectionBO $bo): Collection;

    public function paginate(FetchCollectionBO $bo, int $perPage): LengthAwarePaginator;

    public function findOrFail(int $id): Collection;

    public function update($collection, array $data);

    public function delete($collection): void;
}