<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable =['answer', 'score', 'question_id', 'exam_taker_id', 'marked' ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function embedding(){
        return $this->hasOne(Embedding::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
