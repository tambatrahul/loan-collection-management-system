<?php

namespace App\Modules\User\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Modules\User\BO\CreateUserBO;
use App\Modules\User\BO\FetchUserBO;
use App\Modules\User\BO\UpdateUserBO;
use App\Modules\User\Http\Requests\CreateUserRequest;
use App\Modules\User\Http\Requests\FetchUserRequest;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use App\Modules\User\Http\Resources\UserResource;
use App\Modules\User\Interfaces\Services\UserServiceInterface;
use App\Support\PaginationHelper;
use App\Support\RestResponse;
use Illuminate\Http\JsonResponse;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    ) {}

    /**
     * Display a paginated list of users.
     */
    public function index(FetchUserRequest $request): JsonResponse
    {
        $bo = new FetchUserBO(
            name: $request->validated('name'),
            email: $request->validated('email'),
            role: $request->validated('role'),
        );

        $perPage = PaginationHelper::getPerPage($request);

        $users = $this->userService->paginate($bo, $perPage);

        return RestResponse::paginated(
            paginator: $users,
            data: UserResource::collection($users),
            message: 'Users fetched successfully.'
        );
    }

    /**
     * Store a newly created user.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $bo = new CreateUserBO(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            role: $request->validated('role'),
        );

        $user = $this->userService->create($bo);

        return RestResponse::created(
            data: new UserResource($user),
            message: 'User created successfully.'
        );
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->find($id);

        return RestResponse::success(
            data: new UserResource($user),
            message: 'User fetched successfully.'
        );
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $bo = new UpdateUserBO(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            role: $request->validated('role'),
        );

        $user = $this->userService->update($id, $bo);

        return RestResponse::success(
            data: new UserResource($user),
            message: 'User updated successfully.'
        );
    }

    /**
     * Remove the specified user.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userService->delete($id);

        return RestResponse::success(
            message: 'User deleted successfully.'
        );
    }
}