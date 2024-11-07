<?php

namespace App\Services\Task;

use App\Repositories\TaskRepository;
use App\Services\BaseService;

class TaskService extends BaseService implements TaskServiceInterface
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAll(array $conditions)
    {
        // TODO: Implement getAll() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create(array $attribute)
    {
        return $this->taskRepository->create($attribute);
    }

    public function update($id, $attribute)
    {
        return $this->taskRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->taskRepository->delete($ids);
    }

}
