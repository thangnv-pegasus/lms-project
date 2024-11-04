<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCourseStoreRequest;
use App\Http\Requests\DeleteCourseRequest;
use App\Http\Requests\GetCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseResourceCollection;
use App\Services\Course\CourseServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    protected CourseServiceInterface $courseService;

    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(GetCourseRequest $request): JsonResponse
    {
        $courses = $this->courseService->getAll($request->validated());

        return responseOK(new CourseResourceCollection($courses), paginationFormat($courses));
    }

    public function store(AdminCourseStoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        if (! $course = $this->courseService->store($attributes)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(new CourseResource($course), null, 'create new course is successed');
    }

    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->show($id);

        if (! $course) {
            return responseError(Response::HTTP_NOT_FOUND);
        }

        return responseOK(new CourseResource($course), null, 'show course is successed');
    }

    public function update(UpdateCourseRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        if (! $course = $this->courseService->update($attributes, $request->route('id'))) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }

    public function destroy(DeleteCourseRequest $request): JsonResponse
    {
        $ids = $request->ids;

        if (! $this->courseService->delete($ids)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }
}
