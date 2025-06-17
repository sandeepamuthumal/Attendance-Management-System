<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAllByUserType(int $userTypeId);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function changeStatus(int $id, string $status);
    public function resetPassword(int $id, string $password);
    public function getUserWithRelations(int $id);
}
