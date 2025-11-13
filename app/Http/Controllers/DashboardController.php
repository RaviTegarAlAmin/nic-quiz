<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function studentDashboard(){
        return view('student.dashboard');
    }

    public function teacherDashboard(Teacher $teacher){

        $teacher = auth()->user()->teacher;

        $teacherData = $teacher->load(['teachings.classroom','teachings.course', 'teachings.exams']);

        return view('teacher.dashboard', compact('teacherData'));
    }

    public function adminDashboard(){
        return view('admin.dashboard');
    }
}
