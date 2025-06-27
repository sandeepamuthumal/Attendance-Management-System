<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Carbon\Carbon;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    protected $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findByStudentAndDate(int $studentId, int $enrollmentId, string $date)
    {
        return $this->model
            ->where('students_id', $studentId)
            ->where('students_has_classes_id', $enrollmentId)
            ->whereDate('date', $date)
            ->first();
    }

    public function getPresentStudentsCountByClassAndDate(int $classId, string $date)
    {
        return $this->model
            ->leftJoin('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
            ->where('students_has_classes.classes_id', $classId)
            ->whereDate('attendances.date', $date)
            ->count();
    }

    public function getAttendanceByClass(int $classId, string $date)
    {
        return $this->model
            ->leftJoin('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
            ->where('students_has_classes.classes_id', $classId)
            ->whereDate('attendances.date', $date)
            ->get();
    }

    public function getAttendanceReport(array $filters)
    {
        $query = $this->model
            ->with(['student', 'enrollment.class.subject', 'enrollment.class.grade'])
            ->join('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
            ->join('students', 'attendances.students_id', '=', 'students.id')
            ->join('classes', 'students_has_classes.classes_id', '=', 'classes.id')
            ->select('attendances.*');

        // Apply filters
        if (!empty($filters['class_id'])) {
            $query->where('students_has_classes.classes_id', $filters['class_id']);
        }

        if (!empty($filters['student_id'])) {
            $query->where('attendances.students_id', $filters['student_id']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('attendances.date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('attendances.date', '<=', $filters['end_date']);
        }

        return $query->orderBy('attendances.date', 'desc')
            ->orderBy('attendances.created_at', 'desc')
            ->get();
    }
}
