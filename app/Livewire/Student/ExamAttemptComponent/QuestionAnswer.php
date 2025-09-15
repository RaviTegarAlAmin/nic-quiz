<?php

namespace App\Livewire\Student\ExamAttemptComponent;

use Livewire\Component;

class QuestionAnswer extends Component
{
    public ?array $question = [];


    public function mount(array $question){
        $this->question = $question;
    }

    public function render()
    {
        return view('livewire.student.exam-attempt-component.question-answer');
    }
}
