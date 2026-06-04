<?php

namespace App\Services\Dashboard\Student;

use App\Models\Course;
use App\Models\ExamAssignment;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teaching;
use DB;
use Illuminate\Support\Facades\Cache;

class StudentDashboardService
{

    //Models data
    protected Teaching $teaching;
    protected Student $student;

    protected int $studentId = 0;


    public function __construct()
    {

        $this->student = auth()->user()->entity();

        $this->studentId = $this->student->id;

        $this->teaching = Teaching::whereHas(
            'classroom',
            function ($q) {
                $q->where('id', $this->student->classroom_id);
            }
        )->firstOrFail();
    }

    /*** Wrapper ****/

    public function getDashboardData(): array
    {

        $dashboardData = [
            'active_exams' => $this->getActiveAssignments(),
            'finished_exams' => $this->getFinishedAssignments(),
            'latest_scores' => $this->getLatestExamScores(),
            'average_scores' => $this->getAverageScore(),
        ];

        return $dashboardData;
    }

    /****************/


    //Getting ongoing and upcoming test
    protected function getActiveAssignments(): array
    {

        $activeAssignments =
                    DB::table('exams as e')
                    ->join('courses as c', 'e.course_id', '=', 'c.id')
                    ->join('teachers as t', 'e.teacher_id', '=', 't.id')
                    ->join('exam_assignments as ea', 'ea.exam_id', '=', 'e.id')
                    ->join('exam_takers as et', 'et.exam_assignment_id', '=', 'ea.id')
                    ->where('et.student_id', $this->studentId)
                    ->whereIn('ea.status', ['ongoing', 'not_started', 'on_hold'])
                    ->select('e.title', 'c.name as course', 't.name as teacher', 'et.finished_at', 'et.start_at', 'ea.status as assignment_status', 'ea.id as assignment_id', 'ea.end_at', 'ea.published', 'ea.duration as duration', 'c.code')
                    ->get()
                    ->map(fn($row) => (array) $row)
                    ->toArray();


        return $activeAssignments;

    }

    //Getting completed assignments
    protected function getFinishedAssignments(): array
    {

        $finishedAssignments =  DB::select(
                    '
                        SELECT e.title, c.name as course, t.name as teacher, et.finished_at, et.start_at
                        FROM exams as e
                        JOIN courses as c ON e.course_id = c.id
                        JOIN teachers as t ON e.teacher_id = t.id
                        JOIN exam_assignments as ea ON ea.exam_id = e.id
                        JOIN exam_takers as et ON et.exam_assignment_id = ea.id
                        WHERE et.student_id = ?
                        AND et.finished_at IS NOT NULL
                    ',
                    [$this->studentId]
                );

        return $finishedAssignments;

    }


    //Getting student average score test per course
    protected function getAverageScore(): array
    {


        $results = DB::select('
                    SELECT c.name, c.code, AVG(g.exam_score) as average, COUNT(g.id) as graded_exams
                    FROM courses as c
                    LEFT JOIN exams as e ON c.id = e.course_id
                    LEFT JOIN exam_assignments as ea ON e.id = ea.exam_id
                    LEFT JOIN exam_takers as et ON ea.id = et.exam_assignment_id
                    AND et.student_id = ?
                    LEFT JOIN grades as g ON et.id = g.exam_taker_id
                    GROUP BY c.name, c.code
                ', [$this->studentId]);

        $averageScores =  array_map(fn($row) => (array)$row , $results);

        return $averageScores;
    }


    //getting latest scores from user
    protected function getLatestExamScores(): array
    {

        $latestScores = DB::select(
            '
                SELECT et.id, e.title, t.name, g.exam_score, g.created_at as graded_at, g.updated_at as grade_updated_at, c.name, et.finished_at
                FROM exam_takers as et
                LEFT JOIN grades as g ON et.id = g.exam_taker_id
                LEFT JOIN exam_assignments as ea ON et.exam_assignment_id = ea.id
                LEFT JOIN exams as e ON ea.exam_id = e.id
                LEFT JOIN courses as c ON e.course_id = c.id
                LEFT JOIN teachers as t ON e.teacher_id = t.id
                WHERE et.student_id = ?
                ORDER BY et.created_at DESC
                LIMIT 5
            ', [ $this->studentId ]
        );

        return $latestScores;
    }

}

