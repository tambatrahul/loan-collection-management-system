<?php

namespace App\Modules\Collection\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Collection\BO\CreateCollectionBO;
use App\Modules\Collection\BO\FetchCollectionBO;
use App\Modules\Collection\BO\UpdateCollectionBO;
use App\Modules\Collection\Http\Requests\CreateCollectionRequest;
use App\Modules\Collection\Http\Requests\FetchCollectionRequest;
use App\Modules\Collection\Http\Requests\UpdateCollectionRequest;
use App\Modules\Collection\Http\Resources\CollectionResource;
use App\Modules\Collection\Interfaces\Services\CollectionServiceInterface;
use App\Support\PaginationHelper;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;

final class CollectionController extends Controller
{
    public function __construct(
        private readonly CollectionServiceInterface $collectionService,
    ) {}

    /**
     * Display a paginated list of collections with optional filters.
     */
    public function index(FetchCollectionRequest $request): JsonResponse
    {
        $bo = new FetchCollectionBO(
            loanId: $request->validated('loan_id'),
            paymentMode: $request->validated('payment_mode'),
        );

        $perPage = PaginationHelper::getPerPage($request);

        $collections = $this->collectionService->paginate($bo, $perPage);

        return RestResponse::paginated(
            paginator: $collections,
            data: CollectionResource::collection($collections),
            message: 'Collections fetched successfully.'
        );
    }

    /**
     * Store a newly created collection entry.
     */
    public function store(CreateCollectionRequest $request): JsonResponse
    {
        /** @var \App\Modules\Auth\Models\User $user */
        $user = $request->user();

        $bo = new CreateCollectionBO(
            loanId: (int) $request->validated('loan_id'),
            amountPaid: (float) $request->validated('amount_paid'),
            paymentMode: $request->validated('payment_mode'),
            location: $request->validated('location'),
            collectedAt: $request->validated('collected_at'),
            collectedBy: (int) $user->id,
        );

        $collection = $this->collectionService->create($bo);

        $collection->load(['loan', 'collector']);

        return RestResponse::created(
            data: new CollectionResource($collection),
            message: 'Collection added successfully.'
        );
    }

    /**
     * Display the specified collection.
     */
    public function show(int $id): JsonResponse
    {
        $collection = $this->collectionService->find($id);

        return RestResponse::success(
            data: new CollectionResource($collection),
            message: 'Collection fetched successfully.'
        );
    }

    /**
     * Update the specified collection.
     */
    public function update(
        UpdateCollectionRequest $request,
        int $id
    ): JsonResponse {
        /** @var \App\Modules\Auth\Models\User $user */
        $user = $request->user();

        $validated = $request->validated();

        $bo = new UpdateCollectionBO(
            loanId: (int) $validated['loan_id'],
            amountPaid: (float) $validated['amount_paid'],
            paymentMode: $validated['payment_mode'],
            location: $validated['location'] ?? null,
            collectedAt: $validated['collected_at'],
            collectedBy: (int) $user->id,
        );

        $collection = $this->collectionService->update($id, $bo);

        $collection->load(['loan', 'collector']);

        return RestResponse::success(
            data: new CollectionResource($collection),
            message: 'Collection updated successfully.'
        );
    }

    /**
     * Remove the specified collection.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->collectionService->delete($id);

        return RestResponse::success(
            message: 'Collection deleted successfully.'
        );
    }
}