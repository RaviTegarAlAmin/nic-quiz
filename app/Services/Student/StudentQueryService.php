<?php

namespace App\Services\Student;

use App\Models\Student;
use App\Support\Mapper\Mapper;

class StudentQueryService
{
    public function getAllStudents(){

        return Mapper::toArray(
          Student::all()
        );
    }

    public function getStudentsByClassroomId(int $classroomId) :array{

        return Mapper::toArray(
            Student::where('classroom_id', $classroomId)->orderBy('name')->get()
        );
    }

    public function getStudentByHomeroomTeacherId(int $homeroomTeacherId) :array{

        return Mapper::toArray(
            Student::where('homeroom_teacher_id', $homeroomTeacherId)->orderBy('name')->get()
        );
    }
}
