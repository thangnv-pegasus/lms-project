<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDeleteTaskRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskResource;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LessonTaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {

    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $attribute = $request->validated();

        if (!$task = $this->taskService->create($attribute)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(new TaskResource($task), null, 'Task created successfully');
    }

    public function show($id): JsonResponse
    {
        if (!$task = $this->taskService->show($id)) {
            return responseError(Response::HTTP_NOT_FOUND);
        }

        return responseOK(new TaskResource($task), null, 'Task retrieved successfully');
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        $attribute = $request->validated();

        if (!$task = $this->taskService->update($id, $attribute)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(null, null, 'Task updated successfully');
    }

    public function destroy(AdminDeleteTaskRequest $request)
    {
        $ids = $request->ids;

        if (!$this->taskService->delete($ids)) {
            return responseError(Response::HTTP_NOT_FOUND);
        }

        return responseOK(null, null, 'Task deleted successfully');
    }

}
