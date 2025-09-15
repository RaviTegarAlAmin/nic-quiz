<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teaching extends Model
{
    /** @use HasFactory<\Database\Factories\TeachingFactory> */
    use HasFactory;

    protected $fillable = ['day', 'clock'];

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function examAssignments(){
        return $this->hasMany(ExamAssignment::class);
    }

    public function exams(){
        return $this->belongsToMany(Exam::class, 'exam_assignments');
    }
}
