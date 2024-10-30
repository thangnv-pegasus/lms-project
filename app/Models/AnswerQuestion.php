<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'question_id',
        'is_correct',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
