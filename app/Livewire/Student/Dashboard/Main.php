<?php

namespace App\Livewire\Student\Dashboard;

use App\Services\Dashboard\Student\StudentDashboardService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Main extends Component
{
    #[Layout('layout.main')]

    public array $activeExams;
    public array $finishedExams;
    public array $latestScores;
    public array $averageScores;
    public $tempDashboardData;

    public function mount(){

        $service = new StudentDashboardService();

        $dashboardData = $service->getDashboardData();

        $this->tempDashboardData = $dashboardData;

        $this->activeExams = $dashboardData['active_exams'];
        $this->finishedExams = $dashboardData['finished_exams'];
        $this->latestScores = $dashboardData['latest_scores'];
        $this->averageScores = $dashboardData['average_scores'];
    }

    public function placeholder(){

        return view('livewire.student.dashboard.main-placeholder');

    }

    public function render()
    {
        return view('livewire.student.dashboard.main');
    }
}
