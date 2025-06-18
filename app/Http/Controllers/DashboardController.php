<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
       
        return view('pages.admin.dashboard');
    }

    public function teacherDashboard()
    {
        return view('pages.teacher.dashboard');
    }
}
