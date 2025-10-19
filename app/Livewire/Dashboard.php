<?php

namespace App\Livewire;

use App\Services\ClassService;
use App\Services\DashboardService;
use App\Services\TeacherDashboardService;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    protected $dashboardService, $teacherDashboardService;
    protected $classService;

    public function boot(DashboardService $dashboardService, ClassService $classService, TeacherDashboardService $teacherDashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->classService = $classService;
        $this->teacherDashboardService = $teacherDashboardService;
    }

    public function render()
    {
        if(auth()->user()->hasRole('Admin')){
            $this->stats = $this->dashboardService->getDashboardStats();
        }
        else{
            $this->stats = $this->teacherDashboardService->getDashboardStats();
        }
        return view('livewire.dashboard');
    }
}
