<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
