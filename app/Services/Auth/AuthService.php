<?php

namespace App\Services\Auth;

use App\Repositories\AuthRepository;

class AuthService implements AuthInterface
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

    public function updateProfile($data)
    {
        return $this->authRepository->update(auth()->id(), $data);
    }

}
