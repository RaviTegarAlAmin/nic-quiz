<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    public static array $type = ['multiple_choice', 'essay'];

    protected $fillable = ['exam_id', 'teacher_id', 'question', 'type', 'weight', 'ref_answer'];

    public function exam(){
        $this->belongsTo(Exam::class);
    }

    public function options(){
        $this->hasMany(Option::class);
    }

    public function answer(){
        $this->hasMany(Answer::class);
    }

}
