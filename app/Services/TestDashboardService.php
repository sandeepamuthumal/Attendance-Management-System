<?php

namespace App\Services;

use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\StudentHasClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TestDashboardService
{
    /**
     * Get all dashboard statistics with caching
     */
    public function getDashboardStats(array $filters = []): array
    {
        // Cache for 5 minutes for better performance
        $cacheKey = 'dashboard_stats_' . md5(json_encode($filters));

        return Cache::remember($cacheKey, 300, function () use ($filters) {
            return [
                'overview' => $this->getOverviewStats(),
                'today_attendance' => $this->getTodayAttendanceStats(),
                'weekly_attendance' => $this->getWeeklyAttendanceStats(),
                'recent_attendance' => $this->getRecentAttendance(),
                'class_attendance' => $this->getClassAttendanceStats(),
                'trends' => $this->getTrendStats(),
                'analytics' => $this->getAnalyticsStats(),
                'new_students' => $this->getNewStudentsCount(),
                'classes_today' => $this->getClassesTodayCount(),
                'enrollment_rate' => $this->getEnrollmentRate(),
                'perfect_attendance' => $this->getPerfectAttendanceCount(),
                'at_risk_students' => $this->getAtRiskStudentsCount(),
                'avg_checkin_time' => $this->getAverageCheckInTime(),
            ];
        });
    }

    /**
     * Get filtered dashboard stats based on date range, class, subject
     */
    public function getFilteredStats(array $filters): array
    {
        $dateRange = $this->getDateRange($filters['date_range'] ?? 'today');
        $classId = $filters['class_id'] ?? null;
        $subject = $filters['subject'] ?? null;

        return [
            'overview' => $this->getOverviewStats(),
            'today_attendance' => $this->getFilteredAttendanceStats($dateRange, $classId, $subject),
            'weekly_attendance' => $this->getWeeklyAttendanceStats($classId, $subject),
            'recent_attendance' => $this->getRecentAttendance($classId),
            'class_attendance' => $this->getClassAttendanceStats($dateRange['start']),
            'trends' => $this->getTrendStats(),
            'analytics' => $this->getAnalyticsStats($classId),
        ];
    }

    /**
     * Get overview statistics
     */
    private function getOverviewStats(): array
    {
        return [
            'total_students' => Student::where('status', 1)->count(),
            'total_classes' => ClassModel::where('status', 1)->count(),
            'total_enrollments' => StudentHasClass::where('status', 1)->count(),
            'total_attendance_today' => Attendance::whereDate('date', Carbon::today())->count(),
        ];
    }

    /**
     * Get today's attendance statistics with late status
     */
    private function getTodayAttendanceStats(): array
    {
        $today = Carbon::today();
        $totalStudents = Student::where('status', 1)->count();

        // Get distinct students who marked attendance today
        $presentToday = Attendance::whereDate('date', $today)
            ->distinct('students_id')
            ->count('students_id');

        // Count late arrivals (assuming you have a column for late or time threshold)
        $lateToday = Attendance::whereDate('date', $today)
            ->whereTime('created_at', '>', '08:30:00') // Adjust time as needed
            ->distinct('students_id')
            ->count('students_id');

        $absentToday = $totalStudents - $presentToday;
        $attendanceRate = $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0;

        return [
            'total_students' => $totalStudents,
            'present_today' => $presentToday,
            'absent_today' => $absentToday,
            'late_today' => $lateToday,
            'attendance_rate' => $attendanceRate,
        ];
    }

    /**
     * Get filtered attendance stats based on date range and filters
     */
    private function getFilteredAttendanceStats($dateRange, $classId = null, $subject = null): array
    {
        $query = Attendance::whereBetween('date', [$dateRange['start'], $dateRange['end']]);

        if ($classId) {
            $query->whereHas('enrollment', function ($q) use ($classId) {
                $q->where('classes_id', $classId);
            });
        }

        $totalAttendances = $query->count();
        $presentCount = $query->count();

        $totalStudents = Student::where('status', 1)->count();
        $absentCount = $totalStudents - $presentCount;

        return [
            'total_students' => $totalStudents,
            'present_today' => $presentCount,
            'absent_today' => $absentCount,
            'late_today' => 0, // Calculate based on your logic
            'attendance_rate' => $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100, 1) : 0,
        ];
    }

    /**
     * Get weekly attendance statistics with detailed breakdown
     */
    private function getWeeklyAttendanceStats($classId = null, $subject = null): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Get attendance data for the week
        $attendanceQuery = Attendance::whereBetween('date', [$weekStart, $weekEnd]);

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
        $lateData = [];
        $totalStudents = Student::where('status', 1)->count();

        for ($date = $weekStart->copy(); $date <= $weekEnd; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('D'); // Mon, Tue, etc.

            $present = $weeklyData->get($dateStr)->count ?? 0;
            $late = $this->getLateCountForDate($date);
            $absent = $totalStudents - $present;

            $presentData[] = $present;
            $absentData[] = $absent;
            $lateData[] = $late;
        }

        return [
            'labels' => $labels,
            'present' => $presentData,
            'absent' => $absentData,
            'late' => $lateData,
            'total_week' => array_sum($presentData),
        ];
    }

    /**
     * Get late count for a specific date
     */
    private function getLateCountForDate(Carbon $date): int
    {
        return Attendance::whereDate('date', $date)
            ->whereTime('created_at', '>', '08:30:00') // Adjust threshold
            ->distinct('students_id')
            ->count('students_id');
    }

    /**
     * Get recent attendance with more details
     */
    private function getRecentAttendance($classId = null, $limit = 10): array
    {
        $query = Attendance::with(['student', 'enrollment.class']);

        if ($classId) {
            $query->whereHas('enrollment', function ($q) use ($classId) {
                $q->where('classes_id', $classId);
            });
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($attendance) {
                return [
                    'student_name' => $attendance->student->first_name . ' ' . $attendance->student->last_name,
                    'student_id' => $attendance->student->student_id,
                    'class_name' => $attendance->enrollment->class->class_name ?? 'N/A',
                    'time' => $attendance->created_at->format('h:i A'),
                    'date' => $attendance->date->format('M d'),
                    'status' => $this->getAttendanceStatus($attendance),
                ];
            })
            ->toArray();
    }

    /**
     * Determine attendance status (on-time or late)
     */
    private function getAttendanceStatus($attendance): string
    {
        $checkInTime = Carbon::parse($attendance->created_at);
        $threshold = Carbon::parse($attendance->date->format('Y-m-d') . ' 08:30:00');

        return $checkInTime->gt($threshold) ? 'late' : 'on-time';
    }

    /**
     * Get class attendance statistics (Top 5)
     */
    private function getClassAttendanceStats($date = null): array
    {
        $date = $date ?? Carbon::today();

        return ClassModel::withCount([
            'enrollments as total_students' => function ($query) {
                $query->where('status', 1);
            }
        ])
        ->with(['subject', 'grade'])
        ->where('status', 1)
        ->get()
        ->map(function ($class) use ($date) {
            $presentToday = Attendance::join('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
                ->where('students_has_classes.classes_id', $class->id)
                ->whereDate('attendances.date', $date)
                ->distinct('attendances.students_id')
                ->count('attendances.students_id');

            $attendanceRate = $class->total_students > 0
                ? round(($presentToday / $class->total_students) * 100, 1)
                : 0;

            return [
                'class_name' => $class->class_name,
                'subject' => $class->subject->subject ?? 'N/A',
                'grade' => $class->grade->grade ?? 'N/A',
                'total_students' => $class->total_students,
                'present_today' => $presentToday,
                'attendance_rate' => $attendanceRate,
            ];
        })
        ->sortByDesc('attendance_rate')
        ->take(5)
        ->values()
        ->toArray();
    }

    /**
     * Get trend statistics (month-over-month growth)
     */
    private function getTrendStats(): array
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        // Students trend
        $currentStudents = Student::where('status', 1)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();
        $lastMonthStudents = Student::where('status', 1)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $studentsTrend = $lastMonthStudents > 0
            ? round((($currentStudents - $lastMonthStudents) / $lastMonthStudents) * 100, 1)
            : 0;

        // Enrollments trend
        $currentEnrollments = StudentHasClass::where('status', 1)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();
        $lastMonthEnrollments = StudentHasClass::where('status', 1)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $enrollmentsTrend = $lastMonthEnrollments > 0
            ? round((($currentEnrollments - $lastMonthEnrollments) / $lastMonthEnrollments) * 100, 1)
            : 0;

        return [
            'students' => abs($studentsTrend),
            'enrollments' => abs($enrollmentsTrend),
            'students_direction' => $studentsTrend >= 0 ? 'up' : 'down',
            'enrollments_direction' => $enrollmentsTrend >= 0 ? 'up' : 'down',
        ];
    }

    /**
     * Get analytics statistics (averages, peak days, etc.)
     */
    private function getAnalyticsStats($classId = null): array
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($classId) {
            $query->whereHas('enrollment', function ($q) use ($classId) {
                $q->where('classes_id', $classId);
            });
        }

        $totalStudents = Student::where('status', 1)->count();

        // Calculate averages
        $dailyStats = $query
            ->selectRaw('DATE(date) as attendance_date, COUNT(DISTINCT students_id) as present_count')
            ->groupBy('attendance_date')
            ->get();

        $avgPresent = $dailyStats->avg('present_count');
        $avgPresentPercent = $totalStudents > 0 ? round(($avgPresent / $totalStudents) * 100, 1) : 0;
        $avgAbsentPercent = 100 - $avgPresentPercent;

        // Find peak day
        $peakDay = Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('DAYNAME(date) as day_name, COUNT(*) as count')
            ->groupBy('day_name')
            ->orderByDesc('count')
            ->first();

        return [
            'avg_present' => $avgPresentPercent,
            'avg_absent' => $avgAbsentPercent,
            'peak_day' => $peakDay->day_name ?? 'N/A',
            'total_days_analyzed' => $dailyStats->count(),
        ];
    }

    /**
     * Get new students count (this month)
     */
    private function getNewStudentsCount(): int
    {
        return Student::where('status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    /**
     * Get classes scheduled today
     */
    private function getClassesTodayCount(): int
    {
        return ClassModel::where('status', 1)
            ->whereHas('enrollments', function ($query) {
                $query->where('status', 1);
            })
            ->count();
    }

    /**
     * Get enrollment rate (percentage of capacity)
     */
    private function getEnrollmentRate(): float
    {
        $totalCapacity = 1;
        $totalEnrollments = StudentHasClass::where('status', 1)->count();

        return round(($totalEnrollments / $totalCapacity) * 100, 1);
    }

    /**
     * Get students with perfect attendance (this month)
     */
    private function getPerfectAttendanceCount(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::today();
        $workingDays = $this->getWorkingDaysCount($startOfMonth, $today);

        if ($workingDays === 0) return 0;

        return Student::where('status', 1)
            ->whereHas('attendances', function ($query) use ($startOfMonth, $today) {
                $query->whereBetween('date', [$startOfMonth, $today]);
            }, '=', $workingDays)
            ->count();
    }

    /**
     * Get at-risk students (attendance < 75%)
     */
    private function getAtRiskStudentsCount(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $today = Carbon::today();
        $workingDays = $this->getWorkingDaysCount($startOfMonth, $today);

        if ($workingDays === 0) return 0;

        $threshold = $workingDays * 0.75;

        return Student::where('status', 1)
            ->withCount(['attendances' => function ($query) use ($startOfMonth, $today) {
                $query->whereBetween('date', [$startOfMonth, $today]);
            }])
            ->having('attendances_count', '<', $threshold)
            ->count();
    }

    /**
     * Get average check-in time
     */
    private function getAverageCheckInTime(): string
    {
        $avgTime = Attendance::whereDate('date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('AVG(TIME_TO_SEC(TIME(created_at))) as avg_seconds')
            ->value('avg_seconds');

        if (!$avgTime) return 'N/A';

        $hours = floor($avgTime / 3600);
        $minutes = floor(($avgTime % 3600) / 60);

        return Carbon::createFromTime($hours, $minutes)->format('g:i A');
    }

    /**
     * Get working days count (excluding weekends)
     */
    private function getWorkingDaysCount(Carbon $start, Carbon $end): int
    {
        $workingDays = 0;
        $current = $start->copy();

        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $workingDays++;
            }
            $current->addDay();
        }

        return $workingDays;
    }

    /**
     * Get date range based on filter
     */
    private function getDateRange(string $range): array
    {
        return match ($range) {
            'today' => [
                'start' => Carbon::today(),
                'end' => Carbon::today(),
            ],
            'yesterday' => [
                'start' => Carbon::yesterday(),
                'end' => Carbon::yesterday(),
            ],
            'this_week' => [
                'start' => Carbon::now()->startOfWeek(),
                'end' => Carbon::now()->endOfWeek(),
            ],
            'last_week' => [
                'start' => Carbon::now()->subWeek()->startOfWeek(),
                'end' => Carbon::now()->subWeek()->endOfWeek(),
            ],
            'this_month' => [
                'start' => Carbon::now()->startOfMonth(),
                'end' => Carbon::now()->endOfMonth(),
            ],
            'last_month' => [
                'start' => Carbon::now()->subMonth()->startOfMonth(),
                'end' => Carbon::now()->subMonth()->endOfMonth(),
            ],
            default => [
                'start' => Carbon::today(),
                'end' => Carbon::today(),
            ],
        };
    }

    /**
     * Clear dashboard cache
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
