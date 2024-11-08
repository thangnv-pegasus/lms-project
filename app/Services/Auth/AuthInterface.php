<?php

namespace App\Services\Auth;

interface AuthInterface
{
    public function getUser($data);

    public function updateProfile($data);
}
