<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Services\ClassService;
use App\Services\DashboardService;
use App\Services\TeacherDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService, $teacherDashboardService;
    protected $classService;

    public function __construct(DashboardService $dashboardService, ClassService $classService, TeacherDashboardService $teacherDashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->classService = $classService;
        $this->teacherDashboardService = $teacherDashboardService;
    }
    public function index()
    {
        if(Auth::user()->hasRole('Admin')){
            return redirect()->route('admin.dashboard');
        }
        else if(Auth::user()->hasRole('Teacher')){
            return redirect()->route('teacher.dashboard');
        }

        // If the user type is not recognized, redirect to a default page or show an error
        return redirect('/')->with('error', 'You cannot access this page!');
    }

    public function adminDashboard()
    {
        $stats = $this->dashboardService->getDashboardStats();

        return view('pages.admin.dashboard',compact('stats'));
    }

    public function teacherDashboard()
    {
        $stats = $this->teacherDashboardService->getDashboardStats();

        return view('pages.teacher.dashboard', compact('stats'));
    }
}
