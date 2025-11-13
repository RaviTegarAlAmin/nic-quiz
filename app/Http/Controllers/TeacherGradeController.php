<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use App\Models\Teaching;
use Illuminate\Http\Request;

class TeacherGradeController extends Controller
{
    public function index(Exam $exam){

        return view('grade.teacher.index', compact('exam'));
    }

    public function correction(
        Exam $exam,
        ExamAssignment $assignment,
        Request $request){

        $examTakerId = $request->query('examTakerId');

        $examTakers = ExamTaker::with('student.classroom')->where('exam_assignment_id',$assignment->id)->get();

        $exam = $exam->load('questions.options');


        return view('grade.teacher.correction', compact(['exam','examTakers','examTakerId']));
    }
}
