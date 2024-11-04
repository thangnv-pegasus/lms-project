<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'member_count',
        'department_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Course $course) {
            if (empty($course->slug)) {
                $slugCount = Course::where('slug', Str::slug($course->name))->count();
                $course->slug = $slugCount > 0 ? Str::slug($course->name).($slugCount + 1) : Str::slug($course->name);
            }
        });

        static::updating(function (Course $course) {
            if (empty($course->slug)) {
                $slugCount = Course::where('slug', Str::slug($course->name))->count();
                $course->slug = $slugCount > 0 ? Str::slug($course->name).($slugCount + 1) : Str::slug($course->name);
            }
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
