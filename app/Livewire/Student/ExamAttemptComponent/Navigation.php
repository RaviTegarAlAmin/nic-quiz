<?php

namespace App\Livewire\Student\ExamAttemptComponent;

use App\Livewire\Student\ExamAttempt;
use Livewire\Attributes\On;
use Livewire\Component;

class Navigation extends Component
{
    public ?int $currentIndex = 0;

    public int $lastQuestion = 0;

    #[On('index-changed')]
    public function changeCurrentIndex(int $newIndex){
        $this->currentIndex = $newIndex ?? 0;
    }

    public function navigate(int $index){
        $this->dispatch('navigate', index: $index);
    }



    public function mount(int $currentIndex, int $lastQuestion){
        $this->currentIndex = $currentIndex;
        $this->lastQuestion = $lastQuestion;
    }

    public function render()
    {
        return view('livewire.student.exam-attempt-component.navigation');
    }
}
