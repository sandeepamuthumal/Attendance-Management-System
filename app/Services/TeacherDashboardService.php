<?php

namespace App\Services;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\StudentHasClass;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use App\Repositories\TeacherRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherDashboardService
{
    protected $teacherRepository;
    protected $classService;

    public function __construct(TeacherRepositoryInterface $teacherRepository, ClassService $classService)
    {
        $this->teacherRepository = $teacherRepository;
        $this->classService = $classService;
    }

    public function getDashboardStats(): array
    {
        $teacher_classes = $this->classService->getAllClasses()->pluck('id');
        $enrollments = StudentHasClass::where('status', 1)->whereIn('classes_id', $teacher_classes)->get();



        return [
            'overview' => $this->getOverviewStats($enrollments),
            'today_attendance' => $this->getTodayAttendanceStats($enrollments),
            'weekly_attendance' => $this->getWeeklyAttendanceStats(null, null, $enrollments),
            'recent_attendance' => $this->getRecentAttendance($enrollments),
            'class_attendance' => $this->getClassAttendanceStats($enrollments),
        ];
    }

    private function getOverviewStats($enrollments): array
    {
        return [
            'total_students' => Student::where('status', 1)->whereIn('id', $enrollments->pluck('students_id'))->count(),
            'total_classes' => $this->classService->getAllClasses()->count(),
            'total_enrollments' => $enrollments->count(),
            'total_attendance_today' => Attendance::whereDate('date', Carbon::today())->whereIn('students_has_classes_id', $enrollments->pluck('id'))->count(),
        ];
    }

    private function getTodayAttendanceStats($enrollments): array
    {

        $today = Carbon::today();
        $totalStudents = Student::where('status', 1)->whereIn('id', $enrollments->pluck('students_id'))->count();
        $presentToday = Attendance::whereDate('date', $today)->whereIn('students_has_classes_id', $enrollments->pluck('id'))->distinct('students_id')->count();

        return [
            'total_students' => $totalStudents,
            'present_today' => $presentToday,
            'absent_today' => $totalStudents - $presentToday,
            'attendance_rate' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0,
        ];
    }

    private function getWeeklyAttendanceStats($classId = null, $subject = null, $enrollments = null): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Get attendance data for the week
        $attendanceQuery = Attendance::whereBetween('date', [$weekStart, $weekEnd])->whereIn('students_has_classes_id', $enrollments->pluck('id'));

        if ($classId) {
            $attendanceQuery->whereHas('enrollment', function ($q) use ($classId) {
                $q->where('classes_id', $classId);
            });
        }

        $weeklyData = $attendanceQuery
            ->selectRaw('DATE(date) as attendance_date, COUNT(DISTINCT students_id) as count')
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get()
            ->keyBy('attendance_date');

        $labels = [];
        $presentData = [];
        $absentData = [];
        $totalStudents = Student::where('status', 1)->whereIn('id', $enrollments->pluck('students_id'))->count();

        for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('D'); // Mon, Tue, etc.

            $present = $weeklyData->get($dateStr)->count ?? 0;
            $absent = $totalStudents - $present;

            $presentData[] = $present;
            $absentData[] = $absent;
        }

        return [
            'labels' => $labels,
            'present' => $presentData,
            'absent' => $absentData,
            'total_week' => array_sum($presentData),
        ];
    }

    private function getRecentAttendance($enrollments): array
    {
        return Attendance::with(['student', 'enrollment.class'])
            ->whereIn('students_has_classes_id', $enrollments->pluck('id'))
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

    private function getClassAttendanceStats($enrollments): array
    {
        return ClassModel::withCount([
            'enrollments as total_students' => function ($query) {
                $query->where('status', 1);
            }
        ])
        ->with(['subject', 'grade'])
        ->whereIn('id', $enrollments->pluck('classes_id'))
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
