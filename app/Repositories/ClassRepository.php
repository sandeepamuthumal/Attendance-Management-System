<?php

namespace App\Repositories;

use App\Models\ClassModel;
use App\Models\Teacher;
use App\Repositories\Contracts\ClassRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository implements ClassRepositoryInterface
{
    protected $model;

    public function __construct(ClassModel $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->withRelations()
            ->orderBy('year', 'desc')
            ->orderBy('class_name')
            ->get();
    }

    public function getAllActive(): Collection
    {
        if (auth()->user()->user_types_id == 1) {
            return $this->model->withRelations()
                ->active()
                ->orderBy('year', 'desc')
                ->orderBy('class_name')
                ->get();
        } else {
            $teacher = Teacher::where('users_id', auth()->id())->first();
            return $this->model->withRelations()
                ->active()
                ->byTeacher($teacher->id)
                ->orderBy('year', 'desc')
                ->orderBy('class_name')
                ->get();
        }
    }

    public function getAllWithFilters(array $filters = []): Collection
    {
        $query = $this->model->withRelations()->active();

        if (isset($filters['year']) && $filters['year'] !== '') {
            $query->byYear($filters['year']);
        }

        if (isset($filters['grade_id']) && $filters['grade_id'] !== '') {
            $query->byGrade($filters['grade_id']);
        }

        if (isset($filters['subject_id']) && $filters['subject_id'] !== '') {
            $query->bySubject($filters['subject_id']);
        }

        if (isset($filters['teacher_id']) && $filters['teacher_id'] !== '') {
            $query->byTeacher($filters['teacher_id']);
        }

        return $query->orderBy('year', 'desc')
            ->orderBy('class_name')
            ->get();
    }

    public function findById(int $id): ?ClassModel
    {
        return $this->model->find($id);
    }

    public function create(array $data): ClassModel
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    public function changeStatus(int $id, bool $status): bool
    {
        return $this->model->where('id', $id)->update(['status' => $status]);
    }

    public function getClassWithRelations(int $id): ?ClassModel
    {
        return $this->model->withRelations()->find($id);
    }

    public function checkClassExists(string $className, int $subjectId, int $year, int $excludeId = null): bool
    {
        $query = $this->model->where('class_name', $className)
            ->where('subjects_id', $subjectId)
            ->where('year', $year);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getClassesByTeacher(int $teacherId): Collection
    {
        return $this->model->withRelations()
            ->byTeacher($teacherId)
            ->active()
            ->get();
    }

    public function getClassesByGrade(int $gradeId): Collection
    {
        return $this->model->withRelations()
            ->byGrade($gradeId)
            ->active()
            ->get();
    }

    public function getClassesByYear(int $year): Collection
    {
        return $this->model->withRelations()
            ->byYear($year)
            ->active()
            ->get();
    }

    public function getAllWithRelations()
    {
        return $this->model
            ->with(['subject', 'teacher.user', 'grade'])
            ->get();
    }
}
