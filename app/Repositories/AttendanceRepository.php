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
}
