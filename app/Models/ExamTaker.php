<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamTaker extends Model
{
    protected $fillable = ['exam_assignment_id', 'student_id', 'status', 'duration_used', 'finished_at', 'ip_address', 'last_active_at', 'start_at'];

    public function exams()
    {
        return $this->belongsTo(Exam::class);
    }

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}
