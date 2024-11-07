<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Exercise extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'lesson_task_id',
        'due_date',
    ];

    protected static function booted()
    {
        static::creating(function (Exercise $exercise) {
            $exerciseCount = Exercise::where('slug', Str::slug($exercise->name))->count();

            if ($exerciseCount > 0) {
                $exercise->slug = Str::slug($exercise->name) . '-' . $exerciseCount;
            }

            $exercise->slug = Str::slug($exercise->name);
        });

        static::updating(function (Exercise $exercise) {
            $exerciseCount = Exercise::where('slug', Str::slug($exercise->name))->count();

            if ($exerciseCount > 0) {
                $exercise->slug = Str::slug($exercise->name) . '-' . $exerciseCount;
            }

            $exercise->slug = Str::slug($exercise->name);
        });
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(LessonTask::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
