<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    //Static Variables
    public static array $status = ['finished', 'on_hold', 'not_started', 'published'];

    protected $fillable = ['title', 'start_at', 'end_at', 'duration', 'status', 'course_id', 'teacher_id']; // Duration in minutes

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function examtakers(){
        return $this->hasMany(ExamTaker::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class,'examtakers');
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
