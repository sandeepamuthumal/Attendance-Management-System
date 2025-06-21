<?php

namespace App\Services;

use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\StudentClassRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Carbon\Carbon;

class AttendanceService
{
    protected $attendanceRepository;
    protected $studentRepository;
    protected $studentHasClassRepository;

    public function __construct(
        AttendanceRepositoryInterface $attendanceRepository,
        StudentRepositoryInterface $studentRepository,
        StudentClassRepositoryInterface $studentHasClassRepository
    ) {
        $this->attendanceRepository = $attendanceRepository;
        $this->studentRepository = $studentRepository;
        $this->studentHasClassRepository = $studentHasClassRepository;
    }

    public function validateAndLoadStudent(string $studentId, int $classId, string $date): array
    {
        // Find student
        $student = $this->studentRepository->findActiveByStudentId($studentId);
        if (!$student) {
            throw new \Exception('Student not found');
        }

        // Check enrollment
        $enrollment = $this->studentHasClassRepository->findEnrollment($student->id, $classId);
        if (!$enrollment) {
            throw new \Exception('Student is not enrolled in the selected class');
        }

        // Check if already marked present
        $existingAttendance = $this->attendanceRepository->findByStudentAndDate(
            $student->id,
            $enrollment->id,
            $date
        );

        if ($existingAttendance) {
            throw new \Exception('Student has already been marked present');
        }

        return [
            'student' => $student,
            'enrollment' => $enrollment
        ];
    }

    public function markAttendance(int $studentId, int $enrollmentId, string $date): bool
    {
        try {
            $this->attendanceRepository->create([
                'students_id' => $studentId,
                'students_has_classes_id' => $enrollmentId,
                'date' => $date,
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Failed to mark attendance: ' . $e->getMessage());
        }
    }

    public function getAttendanceStats(int $classId, string $date): array
    {
        $totalStudents = $this->studentHasClassRepository->getActiveStudentsCountByClass($classId);
        $presentStudents = $this->attendanceRepository->getPresentStudentsCountByClassAndDate($classId, $date);

        return [
            'total' => $totalStudents,
            'present' => $presentStudents,
            'absent' => $totalStudents - $presentStudents
        ];
    }
}
