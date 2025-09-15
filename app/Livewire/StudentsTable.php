<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentsTable extends Component
{

    public array $columns = [
        ['label' => 'Nama', 'field' => 'name'],
        ['label' => 'NIS', 'field' => 'nis']
    ];
    public function render()
    {
        $students = Student::where('classroom_id', '1')->get();
        return view('livewire.data-table', ['model' => $students, 'columns' => $this->columns]);
    }
}
