<?php

namespace App\Livewire\Classroom\Teacher;

use App\Models\ExamAssignment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Teaching;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class ClassroomIndex extends Component
{
    public $teachings;

    public $examAssignments;

    public ?Teaching $currentTeaching = null;
    public $currentClassroom;
    public $currentStudents;

    public function mount(Teacher $teacher){
        $this->teachings =  Teaching::where('teacher_id', $teacher->id)->with('classroom', 'course')->get();

    }

    public function changeCurrentTeaching(int $teachingId){

        if ($teachingId == $this->currentTeaching?->id) {
            return;
        }

        $this->currentTeaching = $this->teachings->firstwhere('id', $teachingId);

        $this->currentClassroom = $this->currentTeaching?->classroom;

        $this->currentStudents = Student::where('classroom_id', $this->currentClassroom->id)->orderBy('name')->get();

        $this->examAssignments = ExamAssignment::where('teaching_id', $this->currentTeaching->id)->get();

    }

    public function render()
    {
        return view('livewire.classroom.teacher.classroom-index');
    }
}
