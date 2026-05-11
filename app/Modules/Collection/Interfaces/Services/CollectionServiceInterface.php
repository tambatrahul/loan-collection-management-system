<?php

namespace App\Modules\Collection\Interfaces\Services;

use App\Modules\Collection\BO\CreateCollectionBO;
use App\Modules\Collection\BO\FetchCollectionBO;
use App\Modules\Collection\BO\UpdateCollectionBO;
use App\Modules\Collection\Models\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CollectionServiceInterface
{
    public function create(CreateCollectionBO $bo): Collection;

    public function paginate(FetchCollectionBO $bo, int $perPage): LengthAwarePaginator;

    public function find(int $id): Collection;

    public function update(int $id, UpdateCollectionBO $bo): Collection;

    public function delete(int $id): void;
}
