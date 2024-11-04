<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository extends BaseRepository
{
    public function getModel()
    {
        return Course::class;
    }
}
