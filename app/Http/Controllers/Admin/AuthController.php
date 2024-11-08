<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected AuthInterface $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $credentials['first'] = true;

        $admin = $this->authService->getUser($credentials);

        if (!$admin || !auth()->attempt($request->validated())) {
            return responseError(Response::HTTP_UNAUTHORIZED, 'Login failed');
        }

        return responseOK([
            'token' => $admin->createToken('auth_token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => new UserResource($admin),
        ]);
    }

    public function me(Request $request)
    {
        return responseOK(new UserResource(auth()->user()));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $attributes = $request->validated();
        if (!$this->authService->updateProfile($attributes)) {
            return responseError(Response::HTTP_UNAUTHORIZED, 'Update profile failed');
        }

        return responseOK(null, null, 'Update profile success');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $attribute = $request->validated();

        if(!$this->authService->updateProfile($attribute)) {
            return responseError(Response::HTTP_UNAUTHORIZED, 'Change password failed');
        }

        return responseOK(null, null, 'Change password success');
    }
}
