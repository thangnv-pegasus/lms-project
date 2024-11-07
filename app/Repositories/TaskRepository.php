<?php

namespace App\Repositories;

use App\Models\LessonTask;

class TaskRepository extends BaseRepository
{
    public function getModel()
    {
        return LessonTask::class;
    }
}
