<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAssignment extends Model
{
    use HasFactory;
    protected $fillable = ['start_at', 'end_at', 'duration', 'status', 'teaching_id', 'exam_id', 'published'];

    public static array $status = ['finished', 'on_hold', 'not_started', 'ongoing'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function teaching()
    {
        return $this->belongsTo(Teaching::class);
    }

    public function examTakers(){
        return $this->hasMany(ExamTaker::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class, 'exam_takers');
    }


}
