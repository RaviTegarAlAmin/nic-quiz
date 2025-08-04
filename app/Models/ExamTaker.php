<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamTaker extends Model
{
    public function exams(){
        return $this->belongsTo(Exam::class);
    }

    public function students(){
        return $this->belongsTo(Student::class);
    }
}
