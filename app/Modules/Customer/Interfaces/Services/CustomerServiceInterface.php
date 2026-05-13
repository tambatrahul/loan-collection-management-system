<?php



namespace App\Modules\Customer\Interfaces\Services;

use App\Modules\Customer\BO\CreateCustomerBO;
use App\Modules\Customer\BO\UpdateCustomerBO;
use App\Modules\Customer\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerServiceInterface
{
    public function create(CreateCustomerBO $bo): Customer;

    public function paginate(?int $userId = null, int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): Customer;

    public function update(int $id, UpdateCustomerBO $bo): Customer;

    public function delete(int $id): void;
}