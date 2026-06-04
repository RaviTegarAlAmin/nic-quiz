<?php

namespace App\Livewire\Student\Dashboard;

use Livewire\Component;

class ExamStatusCards extends Component
{
    public array $activeExams = [];
    public array $finishedExams = [];
    public int $ongoing = 0;
    public int $upcoming = 0;
    public int $onhold = 0;
    public int $finished;

    public function mount()
    {

        $this->ongoing = count(
            array_filter(
                $this->activeExams,
                fn($exam) =>
                $exam['assignment_status'] == 'ongoing'
            )
        );

        $this->upcoming = count(
            array_filter(
                $this->activeExams,
                fn($exam) =>
                $exam['assignment_status'] == 'not_started' && $exam['published'] == true
            )
        );

        $this->finished = count($this->finishedExams);
    }

    public function render()
    {
        return view('livewire.student.dashboard.exam-status-cards');
    }
}
