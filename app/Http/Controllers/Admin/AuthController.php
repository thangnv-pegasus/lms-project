<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthInterface;
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

        if (! $admin || ! auth()->attempt($request->validated())) {
            return responseError(Response::HTTP_UNAUTHORIZED, 'Login failed');
        }

        return responseOK([
            'token' => $admin->createToken('auth_token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => new UserResource($admin),
        ]);
    }
}
