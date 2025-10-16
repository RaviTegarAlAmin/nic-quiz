<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isEmpty;

class ExamTaker extends Model
{
    protected $fillable = ['exam_assignment_id', 'student_id', 'status', 'duration_used', 'finished_at', 'ip_address', 'last_active_at', 'start_at'];

    protected $casts = [
        'start_at' => 'datetime',
        'finished_at' => 'datetime',
        'last_active_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examAssignment()
    {
        return $this->belongsTo(ExamAssignment::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function grade(){
        return $this->hasOne(Grade::class);
    }

    public function isFinished() : bool {
        return !empty($this->finished_at);
    }

    public function isAuthorized(int $studentId) : bool {
        return $studentId === $this->student_id;
    }


    //Local Scope Query

    public function filledAnswers(){
        return $this->answers()->whereNotNull('answer');
    }
}
