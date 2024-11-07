<?php

namespace App\Services\Exercise;

use App\Repositories\ExerciseRepository;
use App\Services\BaseService;

class ExcerciseService extends BaseService implements ExerciseServiceInterface
{

    protected $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function getAll(array $conditions)
    {
        return $this->exerciseRepository->filters($conditions);
    }

    public function show($id)
    {
        return $this->exerciseRepository->find($id);
    }

    public function create(array $attribute)
    {
        return $this->exerciseRepository->create($attribute);
    }

    public function update($id, $attribute)
    {
        return $this->exerciseRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->exerciseRepository->delete($ids);
    }
}
