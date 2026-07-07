<?php

namespace App\Services\Schedule;

use App\Models\Classroom;
use App\Models\Period;
use App\Support\Mapper\Mapper;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    public function createScheduleTable(): array
    {
        $classrooms = Classroom::all();
        $periods = Period::all();

        $scheduleTable = [];

        foreach ($classrooms as $classroom) {
            foreach ($periods as $period) {

                $scheduleTable[$classroom->grade][$classroom->name][$period->day][$period->code] =
                    [
                        'start_at' => $period->start_at,
                        'type' => $period->type,
                        'course' => null
                    ];
            }
        }

        return $scheduleTable;

    }

    public function createPeriodScheduleTable(array $defaultData = []): array
    {
        $periods = Period::all();
        $scheduleTable = [];

        foreach ($periods as $period) {
            $scheduleTable[$period->day][$period->code] = array_merge(
                [
                    'start_at' => $period->start_at,
                    'type' => $period->type,
                ],
                $defaultData
            );
        }

        return $scheduleTable;
    }

    public function getMappedSchedulesData(): array
    {
        return $this->mapSchedulesIntoTable(
            $this->getAllSchedule()
        );
    }

    public function getMappedSchedulesByClassroomId(int $classroomId): array
    {
        return $this->mapSchedulesByPeriod(
            $this->getScheduleByClassroomId($classroomId),
            [
                'teacher' => null,
                'course' => null,
                'course_code' => null,
            ]
        );
    }

    public function getMappedSchedulesByTeacherId(int $teacherId): array
    {
        return $this->mapSchedulesByPeriod(
            $this->getScheduleByTeacherId($teacherId),
            [
                'classroom' => null,
                'grade' => null,
                'course' => null,
                'course_code' => null,
            ]
        );
    }

    public function getAllSchedule(): array
    {

        $schedules = DB::select(
            ' SELECT p.day, p.start_at, p.duration, p.code as period_code, sc.id as schedule_id, te.id as teaching_id, t.name as teacher, c.name as course, c.code as course_code, cl.name as classroom , cl.grade as grade
            FROM periods as p
            INNER JOIN schedules as sc on sc.period_id = p.id
            INNER JOIN teachings as te on te.id = sc.teaching_id
            INNER JOIN teachers as t on t.id = te.teacher_id
            INNER JOIN courses as c on c.id = te.course_id
            INNER JOIN classrooms as cl on cl.id = te.classroom_id
            '
        );

        return Mapper::toArray($schedules);

    }

    public function getScheduleByClassroomId(int $classroomId): array
    {

        $schedules =
            DB::select(
                'SELECT p.day, p.start_at, p.duration, p.code as period_code, sc.id as schedule_id, te.id as teaching_id, t.name as teacher, c.name as course, c.code as course_code, cl.name as classroom , cl.grade as grade
                FROM periods as p
                LEFT JOIN schedules as sc on sc.period_id = p.id
                LEFT JOIN teachings as te on te.id = sc.teaching_id
                LEFT JOIN teachers as t on t.id = te.teacher_id
                LEFT JOIN courses as c on c.id = te.course_id
                LEFT JOIN classrooms as cl on cl.id = te.classroom_id
                WHERE cl.id = ?
                ORDER BY p.day, p.start_at
                '
                ,
                [$classroomId]
            );

        return Mapper::toArray($schedules);

    }

    public function getScheduleByTeacherId(int $teacherId): array
    {

        $schedules =
            DB::select(
                'SELECT p.day, p.start_at, p.duration, p.code as period_code, sc.id as schedule_id, te.id as teaching_id, t.name as teacher, c.name as course, c.code as course_code, cl.name as classroom , cl.grade as grade
                FROM periods as p
                LEFT JOIN schedules as sc on sc.period_id = p.id
                LEFT JOIN teachings as te on te.id = sc.teaching_id
                LEFT JOIN teachers as t on t.id = te.teacher_id
                LEFT JOIN courses as c on c.id = te.course_id
                LEFT JOIN classrooms as cl on cl.id = te.classroom_id
                WHERE t.id = ?
                ORDER BY p.day, p.start_at
                '
                ,
                [$teacherId]
            );

        return Mapper::toArray($schedules);
    }

    private function mapSchedulesIntoTable(array $schedules): array
    {
        $scheduleTables = $this->createScheduleTable();

        foreach ($schedules as $schedule) {
            $grade = $schedule['grade'];
            $classroom = $schedule['classroom'];
            $day = $schedule['day'];
            $periodCode = $schedule['period_code'];

            $scheduleTables[$grade][$classroom][$day][$periodCode] = $schedule;
        }

        return $scheduleTables;
    }

    private function mapSchedulesByPeriod(array $schedules, array $defaultData = []): array
    {
        $scheduleTable = $this->createPeriodScheduleTable($defaultData);

        foreach ($schedules as $schedule) {
            $day = $schedule['day'];
            $periodCode = $schedule['period_code'];

            $scheduleTable[$day][$periodCode] = $schedule;
        }

        return $scheduleTable;
    }
}
