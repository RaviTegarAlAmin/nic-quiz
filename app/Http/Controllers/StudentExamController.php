<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use App\Models\Student;
use App\Models\Teaching;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;



        $student = auth()->user()->student;

        $assignments = ExamAssignment::with([
            'exam.questions.options',
            'teaching.classroom',
            'teaching.teacher',
            'teaching.course',
            'examTakerForStudent' // eager load singular relation
        ])
            ->whereHas('teaching.classroom', function ($q) use ($student) {
                $q->where('classroom_id', $student->classroom_id);
            })
            ->where('published', true)
            ->orderBy('end_at')
            ->latest()
            ->get();




        return view('exam.student', compact('assignments', 'student'));
    }

    public function startAttempt(ExamAssignment $assignment)
    {

        try {

            $student = auth()->user()->student;

            $examTaker = ExamTaker::firstOrCreate(
                [
                    'exam_assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                ],
                [
                    'start_at' => now(),
                    'status' => 'ongoing',
                    'last_active_at' => now(),
                    'duration_used' => 0,
                    'ip_address' => request()->ip()
                ]
            );

            return redirect()->route('exams.attempt', ['examTakerId' => $examTaker->id]);

        } catch (\Throwable $th) {
            dd('gagal');
            return redirect()->back()->with('failed', 'Gagal memulai ujian');
        }
    }
}
