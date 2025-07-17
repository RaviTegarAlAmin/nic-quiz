<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTeacher(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;

        $exams = Exam::with('course')->whereHas('course.teachings', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->get();

        return view('exam.teacher', [
            'exams' => $exams,
            'teacher' => $teacher
        ]);
    }

    public function indexStudent(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        $exams = Exam::whereHas('course.teachings', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        });

        return view('exam.teacher', [
            'exams' => $exams,
            'student' => $student
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exam.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
