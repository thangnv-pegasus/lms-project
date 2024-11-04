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

    public function store(array $data)
    {
        return $this->courseRepository->create($data);
    }

    public function show(int $id)
    {
        return $this->courseRepository->find($id);
    }

    public function update(array $data, $id)
    {
        return $this->courseRepository->update($id, $data);
    }

    public function delete(array $ids)
    {
        return $this->courseRepository->delete($ids);
    }
}
