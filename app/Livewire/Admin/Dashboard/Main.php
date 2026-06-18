<?php

namespace App\Livewire\Admin\Dashboard;

use App\Services\Dashboard\Admin\AdminDashboardService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Main extends Component
{

    public array $stats = [];
    public array $schedules = [];
    public array $classrooms= [];



    public function mount(){

        $service = app(AdminDashboardService::class);

        $dashboardData = $service->getDashboardData();

        $this->classrooms = $dashboardData['classroom_data'];
        $this->stats = $dashboardData['stat_card'];
        $this->schedules =  $dashboardData['schedule_data'];

    }

    public function placeholder(){
        return view('livewire.admin.dashboard.main-placeholder');
    }


    #[Layout('layout.main')]
    public function render()
    {
        return view('livewire.admin.dashboard.main');
    }
}
