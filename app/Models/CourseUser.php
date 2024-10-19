<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseUser extends Model
{
    /** @use HasFactory<\Database\Factories\CourseUserFactory> */
    use HasFactory;

    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'role'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
