<?php

namespace App\Modules\Dashboard\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Models\User;
use App\Modules\Dashboard\Http\Resources\BestCollectionTimeResource;
use App\Modules\Dashboard\Http\Resources\DashboardSummaryResource;
use App\Modules\Dashboard\Interfaces\Services\DashboardServiceInterface;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
    ) {}

    public function summary(Request $request): JsonResponse
    {
        $user = $request->user();

        $summary = $this->dashboardService->getSummary($user);

        return RestResponse::success(
            data: new DashboardSummaryResource($summary),
            message: 'Dashboard summary fetched successfully.'
        );
    }

    public function bestCollectionTime(Request $request): JsonResponse
    {
        $user = $request->user();

        $result = $this->dashboardService->getBestCollectionTime($user);

        return RestResponse::success(
            data: new BestCollectionTimeResource($result),
            message: 'Best collection time fetched successfully.'
        );
    }
}