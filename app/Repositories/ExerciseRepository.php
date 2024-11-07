<?php

namespace App\Repositories;

use App\Models\Exercise;

class ExerciseRepository extends BaseRepository
{
    public function getModel()
    {
        return Exercise::class;
    }
}
