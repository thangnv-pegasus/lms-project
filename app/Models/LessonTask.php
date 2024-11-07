<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LessonTask extends Model
{
    /** @use HasFactory<\Database\Factories\LessonTaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'file_path',
        'type',
        'task_url',
        'lesson_id',
    ];

    protected static function booted()
    {
        static::creating(function (LessonTask $task) {
            $taskCount = LessonTask::where('slug', Str::slug($task->name))->count();

            if ($taskCount > 0) {
                $task->slug = Str::slug($task->name) . '-' . ($taskCount + 1);
            }

            $task->slug = Str::slug($task->name);
        });

        static::updating(function (LessonTask $task) {
            $taskCount = LessonTask::where('slug', Str::slug($task->name))->count();

            if ($taskCount > 0) {
                $task->slug = Str::slug($task->name) . '-' . ($taskCount + 1);
            }

            $task->slug = Str::slug($task->name);
        });
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
