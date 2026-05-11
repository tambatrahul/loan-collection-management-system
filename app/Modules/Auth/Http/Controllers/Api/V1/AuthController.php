<?php

namespace App\Modules\Auth\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\Auth\BO\LoginBO;
use App\Modules\Auth\Interfaces\Services\AuthServiceInterface;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Resources\UserResource;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $bo = new LoginBO(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
        
        $result = $this->authService->login($bo);
        $data = [
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ];

        return RestResponse::success($data, 'Login successful.');
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->authService->logout($user);

        return RestResponse::success(message: 'Logout successful.');
    }

    public function me(Request $request): JsonResponse
    {
        /** @var \App\Modules\Auth\Models\User $user */
        $user = $request->user();

        return RestResponse::success(
            data: new UserResource($this->authService->me($user)),
            message: 'User details fetched successfully.'
        );
    }
}