<?php

namespace App\Services\Course;

use App\Services\BaseServiceInterface;

interface CourseServiceInterface extends BaseServiceInterface
{
    public function myCourses(array $conditions);
}
