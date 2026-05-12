<?php

namespace App\Modules\Loan\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Loan\BO\CreateLoanBO;
use App\Modules\Loan\BO\FetchLoanBO;
use App\Modules\Loan\BO\UpdateLoanBO;
use App\Modules\Loan\Http\Requests\CreateLoanRequest;
use App\Modules\Loan\Http\Requests\FetchLoanRequest;
use App\Modules\Loan\Http\Requests\UpdateLoanRequest;
use App\Modules\Loan\Http\Resources\LoanResource;
use App\Modules\Loan\Interfaces\Services\LoanServiceInterface;
use App\Support\PaginationHelper;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;

final class LoanController extends Controller
{
    public function __construct(
        private readonly LoanServiceInterface $loanService,
    ) {}

    /**
     * Display a paginated list of loans with filters.
     */
    public function index(FetchLoanRequest $request): JsonResponse
    {
        $bo = new FetchLoanBO(
            customerName: $request->validated('customer_name'),
            mobile: $request->validated('mobile'),
            status: $request->validated('status'),
        );

        $perPage = PaginationHelper::getPerPage($request);

        $loans = $this->loanService->paginate($bo, $perPage);

        return RestResponse::paginated(
            paginator: $loans,
            data: LoanResource::collection($loans),
            message: 'Loans fetched successfully.'
        );
    }

    /**
     * Store a newly created loan.
     */
    public function store(CreateLoanRequest $request): JsonResponse
    {
        /** @var \App\Modules\Auth\Models\User $user */
        $user = $request->user();

        $bo = new CreateLoanBO(
            loanNo: $this->generateLoanNumber(),
            customerId: (int) $request->validated('customer_id'),
            emiAmount: (float) $request->validated('emi_amount'),
            totalAmount: (float) $request->validated('total_amount'),
            createdBy: (int) $user->id,
        );

        $loan = $this->loanService->create($bo);

        $loan->load('customer')
            ->loadSum('collections', 'amount_paid');

        return RestResponse::created(
            data: new LoanResource($loan),
            message: 'Loan created successfully.'
        );
    }

    /**
     * Display the specified loan.
     */
    public function show(int $id): JsonResponse
    {
        $loan = $this->loanService->find($id);

        return RestResponse::success(
            data: new LoanResource($loan),
            message: 'Loan fetched successfully.'
        );
    }

    /**
     * Update the specified loan.
     */
    public function update(UpdateLoanRequest $request, int $id): JsonResponse
    {
        $bo = new UpdateLoanBO(
            customerId: (int) $request->validated('customer_id'),
            emiAmount: (float) $request->validated('emi_amount'),
            totalAmount: (float) $request->validated('total_amount'),
            status: $request->validated('status'),
        );

        $loan = $this->loanService->update($id, $bo);

        $loan->load('customer')
            ->loadSum('collections', 'amount_paid');

        return RestResponse::success(
            data: new LoanResource($loan),
            message: 'Loan updated successfully.'
        );
    }

    /**
     * Remove the specified loan.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->loanService->delete($id);

        return RestResponse::success(
            message: 'Loan deleted successfully.'
        );
    }
}