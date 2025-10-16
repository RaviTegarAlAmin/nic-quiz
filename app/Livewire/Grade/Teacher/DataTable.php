<?php

namespace App\Livewire\Grade\Teacher;

use App\Models\ExamAssignment;
use Livewire\Component;

class DataTable extends Component
{
    public $assignment;

    public function mount(ExamAssignment $assignment){
        $this->assignment = $assignment;
    }

    public function render()
    {
        return view('livewire.grade.teacher.data-table');
    }
}
