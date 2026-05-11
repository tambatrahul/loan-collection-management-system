<?php



namespace App\Modules\Customer\Interfaces\Repositories;

use App\Modules\Customer\BO\CreateCustomerBO;
use App\Modules\Customer\BO\UpdateCustomerBO;
use App\Modules\Customer\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function create(CreateCustomerBO $bo): Customer;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findOrFail(int $id): Customer;

    public function update(Customer $customer, UpdateCustomerBO $bo): Customer;

    public function delete(Customer $customer): void;
}