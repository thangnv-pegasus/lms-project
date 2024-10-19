<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicYearFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'start_year',
        'end_year',
        'status'
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }
}
