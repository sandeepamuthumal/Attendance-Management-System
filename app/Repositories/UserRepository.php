<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllByUserType(int $userTypeId): Collection
    {
        return $this->model->with(['userType', 'teacher.subject'])
            ->byUserType($userTypeId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->model->where('id', $id)->delete();
    }

    public function changeStatus(int $id, string $status): bool
    {
        return $this->model->where('id', $id)->update(['status' => $status]);
    }

    public function resetPassword(int $id, string $password): bool
    {
        return $this->model->where('id', $id)->update([
            'password' => Hash::make($password)
        ]);
    }

    public function getUserWithRelations(int $id): ?User
    {
        return $this->model->with(['userType', 'teacher.subject'])->find($id);
    }
}
