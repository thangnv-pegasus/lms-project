<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AcademicYear extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicYearFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'start_year',
        'end_year',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function (AcademicYear $academicYear) {
           $academicYear->name = $academicYear->start_year . ' - ' . $academicYear->end_year;
           $academicYear->slug = Str::slug($academicYear->name);
        });

        static::updating(function (AcademicYear $academicYear) {
            $academicYear->name = $academicYear->start_year . ' - ' . $academicYear->end_year;
            $academicYear->slug = Str::slug($academicYear->name);
        });
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }
}
