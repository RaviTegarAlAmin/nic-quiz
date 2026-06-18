<?php

namespace App\Livewire\Admin\Dashboard;

use App\Services\Dashboard\Admin\AdminDashboardService;
use App\Services\Schedule\ScheduleService;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Main extends Component
{
    protected AdminDashboardService $service;

    public $stats;
    public $schedules;
    public $classrooms;



    public function mount(AdminDashboardService $service){

        $this->service = $service;

        $dashboardData = $this->service->getDashboardData();

        $this->classrooms = $dashboardData['classroom_data'];
        $this->stats = $dashboardData['stat_card'];
        $this->schedules =  $dashboardData['schedule_data'];

    }


    #[Layout('layout.main')]
    public function render()
    {
        return view('livewire.admin.dashboard.main');
    }
}
