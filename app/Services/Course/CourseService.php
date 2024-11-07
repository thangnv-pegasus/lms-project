<?php

namespace App\Services\Course;

use App\Repositories\CourseRepository;
use App\Services\BaseService;

class CourseService extends BaseService implements CourseServiceInterface
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAll($conditions)
    {
        return $this->courseRepository->filters($conditions);
    }

    public function create(array $attribute)
    {
        return $this->courseRepository->create($attribute);
    }

    public function show($id)
    {
        return $this->courseRepository->find($id);
    }

    public function update($id, $attribute)
    {
        return $this->courseRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->courseRepository->delete($ids);
    }
}
