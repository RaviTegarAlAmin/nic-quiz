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
}
