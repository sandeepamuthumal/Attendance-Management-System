<?php

namespace App\Repositories\Contracts;

interface TeacherRepositoryInterface
{
    public function create(array $data);
    public function update(int $userId, array $data);
    public function findByUserId(int $userId);
    public function delete(int $userId);
}
