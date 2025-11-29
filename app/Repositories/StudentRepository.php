<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    protected $teacherRepository;

    public function __construct(Student $model, TeacherRepository $teacherRepository)
    {
        $this->model = $model;
        $this->teacherRepository = $teacherRepository;
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

        if(Auth::user()->hasRole('Teacher')){
            $query->whereHas('classes', function ($q) {
                $teacher = $this->teacherRepository->findByUserId(auth()->id());
                $q->where('teachers_id', $teacher->id);
            });
        }

        return $query->orderBy('student_id')->active()->get();
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

    public function getStudentWithUser(int $id): ?Student
    {
        return $this->model->with('user')->find($id);
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
            $query->where('status', 1);
        })->active()->get();
    }

    public function findActiveByStudentId(string $studentId)
    {
        return $this->model
            ->where('student_id', $studentId)
            ->where('status', 1)
            ->first();
    }
}
