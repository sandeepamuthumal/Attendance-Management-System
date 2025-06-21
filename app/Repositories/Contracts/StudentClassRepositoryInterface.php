<?php

namespace App\Repositories\Contracts;

interface StudentClassRepositoryInterface
{
    public function enrollStudent(int $studentId, array $classIds, string $enrolledDate = null);
    public function unenrollStudent(int $studentId, int $classId);
    public function getStudentClasses(int $studentId, bool $activeOnly = true);
    public function getClassStudents(int $classId, bool $activeOnly = true);
    public function updateEnrollmentStatus(int $studentId, int $classId, bool $status);
    public function bulkEnroll(int $studentId, array $classData);
    public function getEnrollmentHistory(int $studentId);
}
