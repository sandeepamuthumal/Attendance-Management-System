<?php

namespace App\Livewire;

use App\Services\ClassService;
use App\Services\DashboardService;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    protected $dashboardService;
    protected $classService;

    public function boot(DashboardService $dashboardService, ClassService $classService)
    {
        $this->dashboardService = $dashboardService;
        $this->classService = $classService;
    }

    public function render()
    {
        $this->stats = $this->dashboardService->getDashboardStats();
        return view('livewire.dashboard');
    }
}
