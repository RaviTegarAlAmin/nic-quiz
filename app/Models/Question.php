<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    public static array $type = ['multiple_choice', 'essay'];

    protected $fillable = ['exam_id', 'teacher_id', 'question', 'question_delta', 'is_rich_text', 'type', 'weight', 'ref_answer'];

    protected $casts = [
        'question_delta' => 'array',
        'is_rich_text' => 'boolean',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }



}
