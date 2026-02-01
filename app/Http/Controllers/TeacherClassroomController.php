<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Teaching;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeacherClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = auth()->user()->teacher;



        return view('classroom.teacher.classroom', compact(['teacher']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
