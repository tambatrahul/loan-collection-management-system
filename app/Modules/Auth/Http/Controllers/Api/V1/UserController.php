<?php

namespace App\Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Interfaces\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {
    }

    public function agents(): JsonResponse
    {
        $agents = $this->userService->getAgents();

        return response()->json([
            'success' => true,
            'message' => 'Agents fetched successfully.',
            'data' => $agents,
        ]);
    }
}