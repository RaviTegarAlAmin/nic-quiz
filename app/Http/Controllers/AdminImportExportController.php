<?php

namespace App\Http\Controllers;

use App\Exports\admin\teacher\TeachersExport;
use App\Exports\admin\student\StudentsExport;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AdminImportExportController extends Controller
{
    public function exportClassroomStudents(int $classroomId)
    {

        $classroom = Classroom::find($classroomId);

        $year = date("Y");

        return (new StudentsExport($classroomId))->download("Siswa-{$classroom->name}-{$year}.xlsx");
    }

    public function importClassroomStudents(int $classroomId)
    {
        $classroom = Classroom::find($classroomId);

    }

    public function exportTeachers()
    {
        $year = date('Y');

        return (new TeachersExport())->download("Guru-{$year}.xlsx");
    }

}
