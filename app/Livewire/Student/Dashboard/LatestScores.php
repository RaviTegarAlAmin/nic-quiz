<?php

namespace App\Livewire\Student\Dashboard;

use Livewire\Component;

class LatestScores extends Component
{
    public array $latestScores;

    public function mount(){


    }

    public function render()
    {
        return view('livewire.student.dashboard.latest-scores');
    }
}
