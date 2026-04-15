<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Str;

class DashboardController extends Controller
{
    public function studentDashboard(User $user){

        if (Str::startsWith($user->entity()->nis, 'PPDB')) {
            return view('student.dashboard-ppdb');
        }

        return view('student.dashboard');
    }

    public function teacherDashboard(Teacher $teacher){

        $teacher = auth()->user()->teacher;

        $teacherData = $teacher->load(['teachings.classroom','teachings.course', 'teachings.exams']);

        $teachings = $teacherData->teachings;

        $courses = $teachings->pluck('course')->unique('id')->values();

        $classrooms = $teachings->pluck('classroom')->unique('id')->values();

        $exams = $teachings->pluck('exams');

        return view('teacher.dashboard', compact(['teacherData','teachings','courses', 'classrooms' , 'exams', 'teacher']));
    }

    public function adminDashboard(){
        return view('admin.dashboard');
    }
}
