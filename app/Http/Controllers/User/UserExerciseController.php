<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class UserExerciseController extends Controller
{
    public function index()
    {
        return responseOK(auth()->user());
    }
}
