<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends BaseRepository
{
    public function getModel()
    {
        return Lesson::class;
    }
}
