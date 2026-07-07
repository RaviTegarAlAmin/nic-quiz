<?php

namespace App\Services\Classroom;

use App\Models\Classroom;

class ClassroomActionService
{

    public function createClassroom(string $name, string $grade, int $capacity): void
    {
        Classroom::create([
            'name' => $name,
            'grade' => $grade,
            'capacity' => $capacity,
            'homeroom_teacher_id' => null,
        ]);
    }


    public function updateClassroom(int $classroomId, string $name, string $grade, int $capacity): void
    {
        $classroom = Classroom::findOrFail($classroomId);

        $classroom->update([
            'name' => $name,
            'grade' => $grade,
            'capacity' => $capacity,
        ]);
    }


    public function changeHomeroomTeacher(int $classroomId, int $newTeacherId): void
    {
        $classroom = Classroom::findOrFail($classroomId);

        $isAlreadyAssigned = Classroom::where('homeroom_teacher_id', $newTeacherId)
            ->where('id', '!=', $classroomId)
            ->exists();

        if ($isAlreadyAssigned) {
            throw new \Exception('Gagal: Guru tersebut sudah menjadi wali kelas di kelas lain.');
        }

        $classroom->update([
            'homeroom_teacher_id' => $newTeacherId
        ]);

    }

    public function removeHomeroomTeacher(int $classroomId): void
    {
        $classroom = Classroom::findOrFail($classroomId);

        $classroom->update([
            'homeroom_teacher_id' => null
        ]);
    }

    public function deleteClassroom(int $classroomId): void
    {
        Classroom::findOrFail($classroomId)->delete();
    }
}
