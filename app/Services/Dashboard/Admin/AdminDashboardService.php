<?php

namespace App\Services\Dashboard\Admin;

use App;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\Schedule\ScheduleService;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;

    }


    public function getDashboardData()
    {
        $data = [];
        $data['stat_card'] = $this->statCard();
        $data['classroom_data'] = $this->classroomData();
        $data['schedule_data'] = $this->scheduleData();
        return $data;
    }

    protected function statCard(): array
    {

        $data['total_students'] = Student::count();
        $data['total_teachers'] = Teacher::count();
        $data['total_classrooms'] = Classroom::count();
        $data['total_courses'] = Course::count();

        return $data;
    }

    protected function classroomData(): array
    {

        $data = DB::select(
            '
            SELECT
                *,
                ROUND((total_students / capacity) * 100) AS occupation
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
            '
        );

        return array_map(fn($row) => (array) $row, $data);
    }

    protected function scheduleData(): array
    {
        return $this->scheduleService->getMappedSchedulesData();
    }

}
