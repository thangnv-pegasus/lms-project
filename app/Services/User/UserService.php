<?php


namespace App\Services\User;

use App\Repositories\UserRepository;
use App\Services\BaseService;

class UserService extends BaseService implements UserServiceInterface
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getAll(array $conditions)
    {
        return $this->userRepository->filters($conditions);
    }

    public function show($id)
    {
        return $this->userRepository->find($id);
    }
    public function create(array $attribute)
    {
        return $this->userRepository->create($attribute);
    }

    public function update($id, $attribute)
    {
        return $this->userRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->userRepository->delete($ids);
    }
}
