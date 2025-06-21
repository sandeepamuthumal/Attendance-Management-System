<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendanceScanner()
    {
        return view('pages.attendance.scanner');
    }
}
