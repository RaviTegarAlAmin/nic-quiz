<?php

namespace App\Livewire\Student\ExamAttemptComponent;

use App\Models\ExamTaker;
use Livewire\Component;

class Timer extends Component
{

    public $examTakerData;

    public int $duration = 1;

    public int $hour = 0;
    public int $minute = 0;

    public int $second = 0;


    public function examFinished()
    {
        $this->dispatch('exam-finished');
    }

    public function heartbeat()
    {
        $updatedDuration = $this->examTakerData->duration_used += 1;

        $this->examTakerData->update([
            'duration_used' => $updatedDuration,
            'last_active_at' => now()
        ]);
    }

    public function mount(int $examDuration, ExamTaker $examTakerData)
    {

        $this->examTakerData = $examTakerData;

        $this->duration = $examDuration - $examTakerData->duration_used;

        $this->hour = (int) ($this->duration / 60);

        $this->minute = ($this->duration % 60);

        $this->second = 0;
    }

    public function render()
    {
        return view('livewire.student.exam-attempt-component.timer');
    }
}
