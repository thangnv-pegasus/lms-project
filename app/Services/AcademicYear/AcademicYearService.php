<?php


namespace App\Services\AcademicYear;

use App\Repositories\AcademicYearRepository;
use App\Services\BaseService;

class AcademicYearService extends BaseService implements AcademicYearServiceInterface
{

    protected $academicYearRepository;

    public function __construct(AcademicYearRepository $academicYearRepository)
    {
        $this->academicYearRepository = $academicYearRepository;
    }
    public function getAll(array $conditions)
    {
        return $this->academicYearRepository->filters($conditions);
    }

    public function show($id)
    {
        return $this->academicYearRepository->find($id);
    }

    public function create(array $attribute)
    {
        return $this->academicYearRepository->create($attribute);
    }

    public function update($id, $attribute)
    {
        return $this->academicYearRepository->update($id, $attribute);
    }

    public function delete(array $ids)
    {
        return $this->academicYearRepository->delete($ids);
    }
}
