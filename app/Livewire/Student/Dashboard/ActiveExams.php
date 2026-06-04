<?php

namespace App\Livewire\Student\Dashboard;

use Livewire\Component;

class ActiveExams extends Component
{

    public array $activeExams = [];
    public array $ongoing = [];
    public array $onhold = [];
    public array $upcoming = [];


    public function mount()
    {

        if (sizeof($this->activeExams) > 0) {
            $this->mapActiveExams();
        }


    }

    protected function mapActiveExams()
    {



        foreach ($this->activeExams as $exam) {

            if ($exam['assignment_status'] == 'ongoing') {
                $this->ongoing[] = $exam;
            } elseif ($exam['assignment_status'] == 'on_hold') {
                $this->onhold[] = $exam;
            } elseif ($exam['assignment_status'] == 'not_started') {
                $this->upcoming[] = $exam;
            }

        }


    }

    public function render()
    {
        return view('livewire.student.dashboard.active-exams');
    }
}
