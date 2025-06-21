<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('classes')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllActive(): Collection
    {
        return $this->model->with('classes')
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllWithFilters(array $filters = []): Collection
    {
        $query = $this->model->with('classes');

        if (isset($filters['search']) && $filters['search'] !== '') {
            $query->search($filters['search']);
        }

        if (isset($filters['class_id']) && $filters['class_id'] !== '') {
            $query->whereHas('classes', function ($q) use ($filters) {
                $q->where('classes.id', $filters['class_id']);
            });
        }

        return $query->orderBy('student_id')->get();
    }

    public function findById(int $id): ?Student
    {
        return $this->model->find($id);
    }

    public function findByStudentId(string $studentId): ?Student
    {
        return $this->model->byStudentId($studentId)->first();
    }

    public function create(array $data): Student
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        // Soft delete by setting status to 0
        return $this->model->where('id', $id)->update(['status' => 0]);
    }

    public function changeStatus(int $id, bool $status): bool
    {
        return $this->model->where('id', $id)->update(['status' => $status]);
    }

    public function getStudentWithClasses(int $id): ?Student
    {
        return $this->model->with(['classes.subject', 'classes.teacher.user', 'classes.grade'])
            ->find($id);
    }

    public function searchStudents(string $search, int $limit = 50): Collection
    {
        return $this->model->search($search)
            ->active()
            ->limit($limit)
            ->get();
    }

    public function getStudentsByClass(int $classId): Collection
    {
        return $this->model->whereHas('classes', function ($query) use ($classId) {
            $query->where('classes.id', $classId);
        })->active()->get();
    }
}
