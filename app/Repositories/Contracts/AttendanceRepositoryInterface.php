<?php

namespace App\Repositories\Contracts;

interface AttendanceRepositoryInterface
{
    public function create(array $data);
    public function findByStudentAndDate(int $studentId, int $enrollmentId, string $date);
    public function getPresentStudentsCountByClassAndDate(int $classId, string $date);
    public function getAttendanceByClass(int $classId, string $date);
}
