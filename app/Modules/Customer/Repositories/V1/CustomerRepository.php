<?php

namespace App\Modules\Customer\Repositories\V1;

use App\Modules\Customer\BO\CreateCustomerBO;
use App\Modules\Customer\BO\UpdateCustomerBO;
use App\Modules\Customer\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Modules\Customer\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

final class CustomerRepository implements CustomerRepositoryInterface
{
    public function create(CreateCustomerBO $bo): Customer
    {
        return Customer::query()->create([
            'name' => $bo->name,
            'mobile' => $bo->mobile,
            'address' => $bo->address,
            'assigned_to' => $bo->assigned_to,
        ]);
    }

    public function paginate(?int $userId = null, int $perPage = 15): LengthAwarePaginator
    {
        return Customer::query()
            ->with('assignedAgent')
            ->when(
                $userId !== null,
                fn ($query) => $query->where('assigned_to', $userId)
            )
            ->latest('id')
            ->paginate($perPage);
    }

    public function findOrFail(int $id): Customer
    {
        return Customer::query()->findOrFail($id);
    }

    public function update(Customer $customer, UpdateCustomerBO $bo): Customer
    {
        $customer->update([
            'name' => $bo->name,
            'mobile' => $bo->mobile,
            'address' => $bo->address,
        ]);

        return $customer->refresh();
    }

    public function delete(Customer $customer): void
    {
        $customer->delete();
    }
}