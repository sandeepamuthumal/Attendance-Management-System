<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\AttendanceService;
use App\Services\ClassService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;
    protected $classService;

    public function __construct(
        AttendanceService $attendanceService,
        ClassService $classService
    ) {
        $this->attendanceService = $attendanceService;
        $this->classService = $classService;
    }


    public function attendanceScanner()
    {
        return view('pages.attendance.scanner');
    }

    public function attendanceReports(Request $request)
    {
        $classes = $this->classService->getAllClasses();
        $students = [];
        $attendanceRecords = [];
        $reportSummary = [];
        $showResults = false;

        // Get students for selected class
        if ($request->filled('class_id')) {
            $students = Student::whereHas('studentClasses', function($query) use ($request) {
                $query->where('classes_id', $request->class_id)
                      ->where('status', 1);
            })->where('status', 1)->get();
        }

        // Generate report if filters are applied
        if ($request->filled('generate_report')) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'class_id' => 'nullable|exists:classes,id',
                'student_id' => 'nullable|exists:students,id',
            ]);

            $filters = [
                'class_id' => $request->class_id,
                'student_id' => $request->student_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];

            $attendanceRecords = $this->attendanceService->getAttendanceReport($filters);
            $reportSummary = $this->attendanceService->getReportSummary($filters);
            $showResults = true;
        }

        return view('pages.attendance.reports', compact(
            'classes',
            'students',
            'attendanceRecords',
            'reportSummary',
            'showResults'
        ));
    }

    public function getStudents(Request $request)
    {
        if (!$request->filled('class_id')) {
            return response()->json([]);
        }

        $students = Student::whereHas('studentClasses', function($query) use ($request) {
            $query->where('classes_id', $request->class_id)
                  ->where('status', 1);
        })->where('status', 1)
        ->select('id', 'student_id', 'first_name', 'last_name')
        ->get();

        return response()->json($students);
    }
}
