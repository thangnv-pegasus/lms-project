<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'course_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Lesson $lesson) {
            $slugCount = Lesson::where('slug', Str::slug($lesson->name))->count();
            if ($slugCount > 0) {
                $lesson->slug = Str::slug($lesson->name) . '-' . ($slugCount + 1);
            }

            $lesson->slug = Str::slug($lesson->name);
        });

        static::updating(function (Lesson $lesson) {
            $slugCount = Lesson::where('slug', Str::slug($lesson->name))->count();
            if ($slugCount > 0) {
                $lesson->slug = Str::slug($lesson->name) . '-' . ($slugCount + 1);
            }

            $lesson->slug = Str::slug($lesson->name);
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(LessonTask::class);
    }
}
