<?php

namespace App\Services;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\StudentHasClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardStats(): array
    {
        return [
            'overview' => $this->getOverviewStats(),
            'today_attendance' => $this->getTodayAttendanceStats(),
            'weekly_attendance' => $this->getWeeklyAttendanceStats(),
            'recent_attendance' => $this->getRecentAttendance(),
            'class_attendance' => $this->getClassAttendanceStats(),
        ];
    }

    private function getOverviewStats(): array
    {
        return [
            'total_students' => Student::where('status', 1)->count(),
            'total_classes' => ClassModel::where('status', 1)->count(),
            'total_enrollments' => StudentHasClass::where('status', 1)->count(),
            'total_attendance_today' => Attendance::whereDate('date', Carbon::today())->count(),
        ];
    }

    private function getTodayAttendanceStats(): array
    {
        $today = Carbon::today();
        $totalStudents = Student::where('status', 1)->count();
        $presentToday = Attendance::whereDate('date', $today)->distinct('students_id')->count();

        return [
            'total_students' => $totalStudents,
            'present_today' => $presentToday,
            'absent_today' => $totalStudents - $presentToday,
            'attendance_rate' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0,
        ];
    }

    private function getWeeklyAttendanceStats(): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $weeklyData = Attendance::whereBetween('date', [$weekStart, $weekEnd])
            ->selectRaw('DATE(date) as attendance_date, COUNT(*) as count')
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get()
            ->keyBy('attendance_date');

        $chartData = [];
        $labels = [];

        for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('M d');
            $chartData[] = $weeklyData->get($dateStr)->count ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $chartData,
            'total_week' => array_sum($chartData),
        ];
    }

    private function getRecentAttendance(): array
    {
        return Attendance::with(['student', 'enrollment.class'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($attendance) {
                return [
                    'student_name' => $attendance->student->first_name . ' ' . $attendance->student->last_name,
                    'student_id' => $attendance->student->student_id,
                    'class_name' => $attendance->enrollment->class->class_name,
                    'time' => $attendance->created_at->format('h:i A'),
                    'date' => $attendance->date->format('M d'),
                ];
            })
            ->toArray();
    }

    private function getClassAttendanceStats(): array
    {
        return ClassModel::withCount([
            'enrollments as total_students' => function ($query) {
                $query->where('status', 1);
            }
        ])
        ->with(['subject', 'grade'])
        ->get()
        ->map(function ($class) {
            $presentToday = Attendance::join('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
                ->where('students_has_classes.classes_id', $class->id)
                ->whereDate('attendances.date', Carbon::today())
                ->count();

            return [
                'class_name' => $class->class_name,
                'subject' => $class->subject->subject ?? 'N/A',
                'grade' => $class->grade->grade ?? 'N/A',
                'total_students' => $class->total_students,
                'present_today' => $presentToday,
                'attendance_rate' => $class->total_students > 0 ? round(($presentToday / $class->total_students) * 100, 1) : 0,
            ];
        })
        ->sortByDesc('attendance_rate')
        ->take(5)
        ->values()
        ->toArray();
    }
}
