<?php

namespace App\Repositories\Contracts;

interface ClassRepositoryInterface
{
    public function getAll();
    public function getAllActive();
    public function getAllWithFilters(array $filters = []);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function changeStatus(int $id, bool $status);
    public function getClassWithRelations(int $id);
    public function checkClassExists(string $className, int $subjectId, int $year, int $excludeId = null);
    public function getClassesByTeacher(int $teacherId);
    public function getClassesByGrade(int $gradeId);
    public function getClassesByYear(int $year);

    public function getAllWithRelations();
}
