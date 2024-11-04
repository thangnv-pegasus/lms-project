<?php

namespace App\Services\Auth;


use App\Repositories\AuthRepository;

class AuthService implements  AuthInterface
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function getUser($data)
    {
        return $this->authRepository->filters($data);
    }
}
