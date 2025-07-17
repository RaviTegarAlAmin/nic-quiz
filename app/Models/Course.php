<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable =['title'];

    public static array $courses = ['IPA', 'IPS', 'Bahasa Indonesia', 'Bahasa Inggris', 'PPKN', 'SBK'];

    public function courseClasrooms() :HasMany {
        return $this->hasMany(CourseClassroom::class);
    }

    public function exams() :HasMany {
        return $this->hasMany(Exam::class);
    }

    public function teachings() :HasMany {
        return $this->hasMany(Teaching::class);
    }

    public function classrooms() :BelongsToMany {
        return $this->belongsToMany(Classroom::class, 'course_classrooms');
    }
    public function teachers() :BelongsToMany {
        return $this->belongsToMany(Teacher::class, 'teachings')->withTimestamps();
    }
}
