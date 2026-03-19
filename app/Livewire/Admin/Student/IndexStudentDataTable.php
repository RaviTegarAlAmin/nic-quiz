<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class IndexStudentDataTable extends Component
{
    public int $currentClassroomId;

    public $currentStudents;

    public function mount(int $classroomId)
    {

        $this->currentClassroomId = $classroomId;
    }

    public function updateCurrentStudents()
    {

        $this->currentStudents = Cache::remember(
            "students.classroom_id:{$this->currentClassroomId}",
            now()->addMinutes(60),
            function () {
                return Student::where('classroom_id', $this->currentClassroomId)->orderBy('name')->get();
            }
        );

    }



    #[On('refresh-table')]
    public function render()
    {

        $this->updateCurrentStudents();

        return view('livewire.admin.student.index-student-data-table');
    }
}
