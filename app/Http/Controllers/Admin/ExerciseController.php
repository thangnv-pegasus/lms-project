<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExerciseDeleteRequest;
use App\Http\Requests\ExerciseStoreRequest;
use App\Http\Requests\ExerciseUpdateRequest;
use App\Http\Requests\GetExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Http\Resources\ExerciseResourceCollection;
use App\Models\Exercise;
use App\Services\Exercise\ExerciseServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    protected ExerciseServiceInterface $exerciseService;

    public function __construct(ExerciseServiceInterface $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    public function index(GetExerciseRequest $request)
    {
        $conditions = $request->validated();
        $exercises = $this->exerciseService->getAll($conditions);

        return responseOK(new ExerciseResourceCollection($exercises), paginationFormat($exercises), 'create success');
    }

    public function show(Exercise $exercise)
    {
        return responseOK(new ExerciseResource($exercise));
    }

    public function store(ExerciseStoreRequest $request)
    {
        $attribute = $request->validated();
        $exercise = $this->exerciseService->create($attribute);

        if (!$exercise) {
            return responseError(Response::HTTP_BAD_REQUEST);
        }

        return responseOK(new ExerciseResource($exercise));
    }

    public function update(Exercise $exercise, ExerciseUpdateRequest $request)
    {
        $attribute = $request->validated();
        if (!$this->exerciseService->update($exercise->id, $attribute)) {
            return responseError(Response::HTTP_BAD_REQUEST);
        }

        return responseOK();
    }

    public function delete(ExerciseDeleteRequest $request)
    {
        $ids = $request->ids;

        if (!$this->exerciseService->delete($ids)) {
            return responseError(Response::HTTP_BAD_REQUEST);
        }

        return responseOK();
    }
}
