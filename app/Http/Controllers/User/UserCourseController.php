<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetUserCourseRequest;
use App\Models\Course;
use App\Services\Course\CourseServiceInterface;
use Illuminate\Http\JsonResponse;

class UserCourseController extends Controller
{
    protected CourseServiceInterface $courseService;

    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(GetUserCourseRequest $request): JsonResponse
    {
        $conditions = $request->validated();

        $courses = $this->courseService->myCourses($conditions);

        return responseOk($courses);
    }

    public function show(Course $course)
    {

    }

    public function store(Course $course, GetUserCourseRequest $request)
    {

    }
}
