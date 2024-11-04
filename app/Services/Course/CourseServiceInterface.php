<?php

namespace App\Services\Course;

interface CourseServiceInterface
{
    public function getAll($conditions);

    public function store(array $data);

    public function update(array $data, int $id);

    public function delete(array $ids);
}
