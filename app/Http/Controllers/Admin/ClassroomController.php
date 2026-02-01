<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $classrooms = Classroom::orderBy('grade')
            ->withCount([
                'students as total_students',
                'students as male_students' => function (Builder $q) {
                    $q->where('gender', 'Laki-Laki');
                },
                'students as female_students' => function (Builder $q) {
                    $q->where('gender', 'Perempuan');
                },
            ])
            ->get();


        return view('admin.classroom.index', compact('classrooms'));

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
    public function destroy(Classroom $classroom, User $user)
    {

        abort_if(!auth()->user()->isAdmin(), 403);

        try {
            $classroom->delete();

            return back()->with('success', 'Kelas berhasil dihapus');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal memperbaharui kelas');
        }



    }
}
