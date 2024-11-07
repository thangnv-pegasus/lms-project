<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGetUserRequest;
use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(AdminGetUserRequest $request)
    {
        $users = $this->userService->getAll($request->validated());

        return responseOK(new UserResourceCollection($users), paginationFormat($users));
    }

    public function store(UserStoreRequest $request)
    {
        $attributes = $request->validated();
        $attributes['role'] = User::ROLE_STUDENT;
        $user = $this->userService->create($attributes);
        if (!$user) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(new UserResource($user), null, 'create user success');
    }

    public function show(User $user)
    {
        return responseOK(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $attributes = $request->validated();

        if (!$this->userService->update($user, $attributes)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }

    public function destroy(UserDeleteRequest $request)
    {
        $ids = $request->ids;

        if (!$this->userService->delete($ids)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }
}
