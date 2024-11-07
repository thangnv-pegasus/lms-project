<?php

namespace App\Repositories;

use App\Models\AcademicYear;

class AcademicYearRepository extends BaseRepository
{
    public function getModel()
    {
        return AcademicYear::class;
    }
}
