<?php

namespace App\Services\Lesson;

use App\Repositories\LessonRepository;
use App\Services\BaseService;

class LessonService extends BaseService implements LessonServiceInterface
{
    protected $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function getAll(array $conditions)
    {
        // TODO: Implement getAllLessons() method.
    }

    public function show($id)
    {
        return $this->lessonRepository->find($id);
    }

    public function create(array $attributes)
    {
        return $this->lessonRepository->create($attributes);
    }

    public function update($id, $attribute)
    {
        return $this->lessonRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->lessonRepository->delete($ids);
    }
}
