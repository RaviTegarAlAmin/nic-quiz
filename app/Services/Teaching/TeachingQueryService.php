<?php

namespace App\Services\Teaching;

use App\Support\Mapper\Mapper;
use Illuminate\Support\Facades\DB;

class TeachingQueryService
{
    private function baseQuery(): string
    {
        return '
            SELECT
                te.id AS teaching_id,
                c.id AS classroom_id,
                c.name AS classroom_name,
                c.grade,
                co.id AS course_id,
                co.name AS course_name,
                co.code AS course_code,
                t.id AS teacher_id,
                t.name AS teacher_name
            FROM teachings AS te
            JOIN classrooms AS c ON c.id = te.classroom_id
            JOIN courses AS co ON co.id = te.course_id
            JOIN teachers AS t ON t.id = te.teacher_id
        ';
    }

    public function getAllTeachings(): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' ORDER BY c.grade, c.name')
        );
    }

    public function getTeachingsByTeacherId(int $teacherId): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' WHERE te.teacher_id = ? ORDER BY c.grade, c.name', [$teacherId])
        );
    }

    public function getTeachingsByClassroomId(int $classroomId): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' WHERE te.classroom_id = ? ORDER BY co.name', [$classroomId])
        );
    }

    public function getTeachingsByCourseId(int $courseId): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' WHERE te.course_id = ? ORDER BY c.grade, c.name', [$courseId])
        );
    }

    public function getTeachingByTeacherIdAndClassroomId(int $teacherId, int $classroomId): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' WHERE te.teacher_id = ? AND te.classroom_id = ?', [$teacherId, $classroomId])
        );
    }
}
