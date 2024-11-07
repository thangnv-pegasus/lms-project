<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearDeleteRequest;
use App\Http\Requests\AcademicYearStoreRequest;
use App\Http\Requests\AcademicYearUpdateRequest;
use App\Http\Requests\GetAcademicYearRequest;
use App\Http\Resources\AcademicYearResource;
use App\Http\Resources\AcademicYearResourceCollection;
use App\Models\AcademicYear;
use App\Services\AcademicYear\AcademicYearServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class AcademicYearController extends Controller
{
    protected $academicYearService;

    public function __construct(AcademicYearServiceInterface $academicYearService)
    {
        $this->academicYearService = $academicYearService;
    }

    public function index(GetAcademicYearRequest $request)
    {
        $conditions = $request->validated();
        $academicYears = $this->academicYearService->getAll($conditions);

        return responseOK(new AcademicYearResourceCollection($academicYears), paginationFormat($academicYears), 'get academic year success');
    }

    public function store(AcademicYearStoreRequest $request)
    {
        $conditions = $request->validated();
        $academicYear = $this->academicYearService->create($conditions);

        if (!$academicYear) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK(new AcademicYearResource($academicYear), 'academic year create success');

    }

    public function update(AcademicYearUpdateRequest $request, AcademicYear $academicYear)
    {
        $conditions = $request->validated();

        if(!$this->academicYearService->update($academicYear->id, $conditions)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }

    public function destroy(AcademicYearDeleteRequest $request)
    {
        $ids = $request->ids;
        if(!$this->academicYearService->delete($ids)) {
            return responseError(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return responseOK();
    }

    public function show(AcademicYear $academicYear)
    {
        return responseOK(new AcademicYearResource($academicYear));
    }
}
