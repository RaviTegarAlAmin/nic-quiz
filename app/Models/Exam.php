<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    //Static Variables
    public static array $status = ['finished', 'on_hold', 'not_started'];

    protected $fillable = ['start_at', 'end_at', 'duration', 'status']; // Duration in minutes

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function grades(){
        return $this->hasMany(Grade::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class,'grades');
    }
}
