<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        if(Auth::user()->user_types_id == 1){
            return redirect()->route('admin.dashboard');
        }
        else if(Auth::user()->user_types_id == 2){
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
        $stats = $this->dashboardService->getDashboardStats();
        return view('pages.teacher.dashboard', compact('stats'));
    }
}
