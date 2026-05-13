<?php

namespace App\Modules\Customer\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Customer\BO\CreateCustomerBO;
use App\Modules\Customer\BO\UpdateCustomerBO;
use App\Modules\Customer\Http\Requests\CreateCustomerRequest;
use App\Modules\Customer\Http\Requests\UpdateCustomerRequest;
use App\Modules\Customer\Http\Resources\CustomerResource;
use App\Modules\Customer\Interfaces\Services\CustomerServiceInterface;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Support\PaginationHelper;


final class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerServiceInterface $customerService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = PaginationHelper::getPerPage($request);

        $user = $request->user();

        $userId = $user->role->name === 'ADMIN'
            ? null
            : $user->id;

        $customers = $this->customerService->paginate($userId, $perPage);

        return RestResponse::paginated(
            paginator: $customers,
            data: CustomerResource::collection($customers),
            message: 'Customers fetched successfully.'
        );
    }

    public function store(CreateCustomerRequest $request): JsonResponse
    {
        $bo = new CreateCustomerBO(
            name: $request->validated('name'),
            mobile: $request->validated('mobile'),
            address: $request->validated('address'),
            assigned_to: $request->validated('assigned_to'),
        );

        $customer = $this->customerService->create($bo);

        return RestResponse::created(
            data: new CustomerResource($customer),
            message: 'Customer created successfully.'
        );
    }

    public function show(int $id): JsonResponse
    {
        $customer = $this->customerService->find($id);

        return RestResponse::success(
            data: new CustomerResource($customer),
            message: 'Customer fetched successfully.'
        );
    }

    public function update(UpdateCustomerRequest $request, int $id): JsonResponse
    {
        $bo = new UpdateCustomerBO(
            name: $request->validated('name'),
            mobile: $request->validated('mobile'),
            address: $request->validated('address'),
        );

        $customer = $this->customerService->update($id, $bo);

        return RestResponse::success(
            data: new CustomerResource($customer),
            message: 'Customer updated successfully.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->customerService->delete($id);

        return RestResponse::success(
            message: 'Customer deleted successfully.'
        );
    }
}