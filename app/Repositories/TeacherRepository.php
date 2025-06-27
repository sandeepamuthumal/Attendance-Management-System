<?php

namespace App\Repositories;

use App\Models\Teacher;
use App\Repositories\Contracts\TeacherRepositoryInterface;

class TeacherRepository implements TeacherRepositoryInterface
{
    protected $model;

    public function __construct(Teacher $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Teacher
    {
        return $this->model->create($data);
    }

    public function update(int $userId, array $data): bool
    {
        return $this->model->where('users_id', $userId)->update($data);
    }

    public function findByUserId(int $userId): ?Teacher
    {
        return $this->model->where('users_id', $userId)->first();
    }

    public function delete(int $userId): bool
    {
        return $this->model->where('users_id', $userId)->delete();
    }
}
