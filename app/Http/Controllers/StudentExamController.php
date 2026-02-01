<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use App\Models\Question;
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


    public function result(ExamAssignment $assignment)
    {
        $student = auth()->user()->student->load('classroom');

        $exam = $assignment->exam;

        $questions = $exam->questions;


        $examTaker = ExamTaker::where('student_id', $student->id)
            ->where('exam_assignment_id', $assignment->id)->
            with('grade')
            ->firstOrFail();

        $answers = Answer::where('exam_taker_id', $examTaker->id)->get();

        $questionAnswers = Answer::where('exam_taker_id', $examTaker->id)
            ->with('question')
            ->get();

        $mcqQuestions =
        $questionAnswers
        ->filter(fn ($answer) => $answer->question && $answer->question->type == 'multiple_choice')->count();

        $essayQuestions =
        $questionAnswers
        ->filter(fn ($answer) => $answer->question && $answer->question->type == 'essay')->count();

        return view('exam.student-result', compact(['student', 'examTaker', 'assignment', 'questionAnswers', 'mcqQuestions', 'essayQuestions','questions']));
    }

    //Control examtaker
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
