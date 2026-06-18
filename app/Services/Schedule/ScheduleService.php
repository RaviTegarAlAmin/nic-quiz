<?php

namespace App\Services\Schedule;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    public function createScheduleTable()
    {
        $classrooms = Classroom::all();
        $periods = Period::all();

        $scheduleTable = [];

        foreach ($classrooms as $classroom) {
            foreach ($periods as $period) {

                $scheduleTable[$classroom->grade][$classroom->name][$period->day][$period->code] =
                    [
                        'start_at'  => $period->start_at,
                        'type'      => $period->type,
                        'course'    => null
                    ];
            }
        }

        return $scheduleTable;

    }

    public function getAllSchedule()
    {

        return DB::select(
            ' SELECT p.day, p.start_at, p.duration, p.code as period_code, sc.id as schedule_id, te.id as teaching_id, t.name as teacher, c.name as course, c.code as course_code, cl.name as classroom , cl.grade as grade
            FROM periods as p
            INNER JOIN schedules as sc on sc.period_id = p.id
            INNER JOIN teachings as te on te.id = sc.teaching_id
            INNER JOIN teachers as t on t.id = te.teacher_id
            INNER JOIN courses as c on c.id = te.course_id
            INNER JOIN classrooms as cl on cl.id = te.classroom_id
            '
        );
        ;

    }

    public function getScheduleByClassroomId(int $classroomId)
    {

        return
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
        ;

    }

    public function getScheduleByTeacherId(int $teacherId)
    {

        return
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

        ;
    }




}
