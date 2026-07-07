<?php

namespace App\Services\Classroom;

use App\Support\Mapper\Mapper;
use Illuminate\Support\Facades\DB;

class ClassroomQueryService
{
    private function baseQuery(): string
    {
        return '
            SELECT
                *,
                ROUND((total_students / NULLIF(capacity, 0)) * 100) AS occupancy
            FROM (
                SELECT
                    c.id,
                    c.name,
                    c.grade,
                    t.id AS teacher_id,
                    t.name AS homeroom_teacher,
                    c.capacity,
                    COUNT(s.id) AS total_students
                FROM classrooms AS c
                LEFT JOIN teachers AS t ON c.homeroom_teacher_id = t.id
                LEFT JOIN students AS s ON s.classroom_id = c.id
                GROUP BY c.id, c.name, c.grade, t.id, t.name, c.capacity
            ) AS classroom_summary
        ';
    }

    public function getAllClassroomsWithSummary(): array
    {
        $data = Mapper::toArray(
            DB::select($this->baseQuery() . ' ORDER BY grade, name')
        );

        return $data;
    }

    public function getClassroomSummaryByClassroomId(int $classroomId): array
    {
        return Mapper::toSingleArray(
            DB::select($this->baseQuery() . ' WHERE id = ?', [$classroomId])
        );
    }

    public function getAllClassroomsByGrade(string $grade): array
    {
        return Mapper::toArray(
            DB::select($this->baseQuery() . ' WHERE grade = ? ORDER BY name', [$grade])
        );
    }

    public function getClassroomByTeacherId(int $teacherId): array
    {
        return Mapper::toSingleArray(
            DB::select($this->baseQuery() . ' WHERE teacher_id = ?', [$teacherId])
        );
    }

    public function getClassroomByStudentId(int $studentId): array
    {
        return Mapper::toSingleArray(
            DB::select('
                SELECT * FROM (' . $this->baseQuery() . ') AS summary
                WHERE id = (
                    SELECT classroom_id FROM students WHERE id = ? LIMIT 1
                )
            ', [$studentId])
        );
    }

    public function getClassroomOverview(int $classroomId): array
    {
        return Mapper::toSingleArray(
            DB::select(
                ' SELECT
                c.id,
                c.name,
                c.grade,
                c.capacity,

                COALESCE(student_summary.total_students, 0) AS total_students,
                COALESCE(student_summary.female_students, 0) AS female_students,
                COALESCE(student_summary.male_students, 0) AS male_students,

                ROUND(
                    COALESCE(student_summary.total_students, 0) / NULLIF(c.capacity, 0) * 100
                ) AS occupancy,

                t.id AS teacher_id,
                t.name AS homeroom_teacher_name,
                t.gender AS teacher_gender,
                t.nip,

                teaching_summary.subjects

            FROM classrooms c

            LEFT JOIN teachers t
                ON t.id = c.homeroom_teacher_id

            LEFT JOIN (
                SELECT
                    classroom_id,
                    COUNT(id) AS total_students,
                    SUM(CASE WHEN gender = "Perempuan" THEN 1 ELSE 0 END) AS female_students,
                    SUM(CASE WHEN gender = "Laki-Laki" THEN 1 ELSE 0 END) AS male_students
                FROM students
                GROUP BY classroom_id
            ) AS student_summary
                ON student_summary.classroom_id = c.id

            LEFT JOIN (
                SELECT
                    teaching.teacher_id,
                    GROUP_CONCAT(
                        DISTINCT course.name
                        ORDER BY course.name
                        SEPARATOR ", "
                    ) AS subjects
                FROM teachings AS teaching
                LEFT JOIN courses AS course
                    ON course.id = teaching.course_id
                GROUP BY teaching.teacher_id
            ) AS teaching_summary
                ON teaching_summary.teacher_id = t.id

            WHERE c.id = ?

                ',
                [$classroomId]
            )
        );

    }
}
