<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    //Static Variables


    protected $fillable = ['title', 'course_id', 'teacher_id']; // Duration in minutes

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'examtakers');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function examAssignments()
    {
        return $this->hasMany(ExamAssignment::class);
    }

    public function teachings()
    {
        return $this->belongsToMany(Teaching::class, 'exam_assignments');
    }
}
