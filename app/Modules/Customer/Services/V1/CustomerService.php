<?php

namespace App\Modules\Customer\Services\V1;

use App\Modules\Customer\BO\CreateCustomerBO;
use App\Modules\Customer\BO\UpdateCustomerBO;
use App\Modules\Customer\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Modules\Customer\Interfaces\Services\CustomerServiceInterface;
use App\Modules\Customer\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

final class CustomerService implements CustomerServiceInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {}

    public function create(CreateCustomerBO $bo): Customer
    {
        return $this->customerRepository->create($bo);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->customerRepository->paginate($perPage);
    }

    public function find(int $id): Customer
    {
        return $this->customerRepository->findOrFail($id);
    }

    public function update(int $id, UpdateCustomerBO $bo): Customer
    {
        $customer = $this->customerRepository->findOrFail($id);

        return $this->customerRepository->update($customer, $bo);
    }

    public function delete(int $id): void
    {
        $customer = $this->customerRepository->findOrFail($id);

        $this->customerRepository->delete($customer);
    }
}