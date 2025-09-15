<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ExamController extends Controller
{
    /*
        THIS CONTROLLER USED FOR TEACHER CONTROLLER ONLY, RESTRUCTURED AT DEV
    */

    /**
     * Display a listing of the resource.
     */
    public function indexTeacher(Request $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;

        $exams = Exam::with(['course', 'examAssignments.teaching.classroom'])
            ->where('teacher_id', $teacher->id)
            ->withCount([
                'questions as multiple_choice_count' => function ($q) {
                    $q->where('type', 'multiple_choice');
                },
                'questions as essay_count' => function ($q) {
                    $q->where('type', 'essay');
                },
            ])
            ->latest()
            ->get();


        return view('exam.teacher', [
            'exams' => $exams,
            'teacher' => $teacher
        ]);
    }

    public function indexStudent(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        return view('exam.student');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::with(['teachings.classroom'])
            ->whereHas('teachings', function ($q) {
                $q->where('teacher_id', auth()->user()->teacher->id);
            })->get();


        return view('exam.create', [
            'courses' => $courses
        ]);
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
    public function show(Exam $exam)
    {
        return view('exam.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {

        return view('exam.edit', ['exam' => $exam]);
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
