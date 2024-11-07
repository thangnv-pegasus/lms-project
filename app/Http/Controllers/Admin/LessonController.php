<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonDeleleRequest;
use App\Http\Requests\LessonStoreRequest;
use App\Http\Requests\LessonUpdateRequest;
use App\Http\Resources\LessonResource;
use App\Services\Lesson\LessonServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class LessonController extends Controller
{
    protected LessonServiceInterface $lessonService;

    public function __construct(LessonServiceInterface $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index()
    {

    }

    public function show(int $id)
    {

    }

    public function store(LessonStoreRequest $request)
    {
        $attributes = $request->validated();

        if (!$lesson = $this->lessonService->create($attributes)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(new LessonResource($lesson), null, 'Lesson created successfully');
    }

    public function update(LessonUpdateRequest $request, $id)
    {
        if (!$lesson = $this->lessonService->update($id, $request->validated())) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(null, null, 'Lesson updated successfully');
    }

    public function destroy(LessonDeleleRequest $request)
    {
        if (!$this->lessonService->delete($request->ids)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }
}
