<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, Authenticatable;

    protected $fillable = ['classroom_id', 'nis', 'name', 'gender', 'born_date', 'address', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function examAssignments()
    {
        return $this->belongsToMany(ExamAssignment::class, 'exam_takers');
    }


    protected static function booted()
    {

        static::saved(
            fn($student) =>
            Cache::forget("students.classroom_id:{$student->classroom_id}")
        );

        static::deleted(
            fn($student) =>
            Cache::forget("students.classroom_id:{$student->classroom_id}")
        );
    }


    public function hasExam(Exam $exam): bool
    {
        return $this->examAssignments()->where('exam_id', $exam->id)->exists();
    }

}
