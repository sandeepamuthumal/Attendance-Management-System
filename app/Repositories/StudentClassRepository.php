<?php

namespace App\Repositories;

use App\Models\StudentHasClass;
use App\Repositories\Contracts\StudentClassRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StudentClassRepository implements StudentClassRepositoryInterface
{
    protected $model;

    public function __construct(StudentHasClass $model)
    {
        $this->model = $model;
    }

    public function enrollStudent(int $studentId, array $classIds, string $enrolledDate = null): bool
    {
        try {
            DB::beginTransaction();

            $enrolledDate = $enrolledDate ?: now()->toDateString();

            foreach ($classIds as $classId) {
                $this->model->updateOrCreate(
                    [
                        'students_id' => $studentId,
                        'classes_id' => $classId
                    ],
                    [
                        'enrolled_date' => $enrolledDate,
                        'status' => 1
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function unenrollStudent(int $studentId, int $classId): bool
    {
        return $this->model->where('students_id', $studentId)
            ->where('classes_id', $classId)
            ->update(['status' => 0]);
    }

    public function getStudentClasses(int $studentId, bool $activeOnly = true): Collection
    {
        $query = $this->model->with(['class.subject', 'class.teacher.user', 'class.grade'])
            ->forStudent($studentId);

        if ($activeOnly) {
            $query->active();
        }

        return $query->get();
    }

    public function getClassStudents(int $classId, bool $activeOnly = true): Collection
    {
        $query = $this->model->with('student')
            ->forClass($classId);

        if ($activeOnly) {
            $query->active();
        }

        return $query->get();
    }

    public function updateEnrollmentStatus(int $studentId, int $classId, bool $status): bool
    {
        return $this->model->where('students_id', $studentId)
            ->where('classes_id', $classId)
            ->update(['status' => $status]);
    }

    public function bulkEnroll(int $studentId, array $classData): bool
    {
        try {
            DB::beginTransaction();

            // First, deactivate all current enrollments
            $this->model->forStudent($studentId)->update(['status' => 0]);

            // Then create new enrollments
            foreach ($classData as $data) {
                $this->model->updateOrCreate(
                    [
                        'students_id' => $studentId,
                        'classes_id' => $data['class_id']
                    ],
                    [
                        'enrolled_date' => $data['enrolled_date'] ?? now()->toDateString(),
                        'status' => 1
                    ]
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getEnrollmentHistory(int $studentId): Collection
    {
        return $this->model->with(['class.subject', 'class.teacher.user'])
            ->forStudent($studentId)
            ->orderBy('enrolled_date', 'desc')
            ->get();
    }
}
