<?php

namespace App\Livewire\Admin\Classroom;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public bool $classroomSelected = false;
    public bool $toast = false;
    public bool $modalForm = false;

    #[On('classroom-selected')]
    public function onClassroomSelected(){
        $this->classroomSelected = true;
    }

    #[On('show-toast')]
    public function showToast(){
        $this->toast = true;
    }

    #[On('show-modal')]
    public function showModal(){
        $this->modalForm = true;
    }


    #[Layout('layout.main')]
    public function render()
    {
        return view('livewire.admin.classroom.index');
    }
}
