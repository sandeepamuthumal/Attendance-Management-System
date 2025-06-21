<?php

namespace App\Repositories\Contracts;

interface StudentRepositoryInterface
{
    public function getAll();
    public function getAllActive();
    public function getAllWithFilters(array $filters = []);
    public function findById(int $id);
    public function findByStudentId(string $studentId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function changeStatus(int $id, bool $status);
    public function getStudentWithClasses(int $id);
    public function searchStudents(string $search, int $limit = 50);
    public function getStudentsByClass(int $classId);
}
