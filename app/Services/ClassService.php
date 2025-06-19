<?php

namespace App\Services;

use App\Repositories\Contracts\ClassRepositoryInterface;
use App\Services\AuditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ClassService
{
    protected $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function getClassesWithFilters(array $filters = [])
    {
        try {
            $classes = $this->classRepository->getAllWithFilters($filters);

            return $classes->map(function ($class) {
                return [
                    'id' => $class->id,
                    'class_name' => $class->class_name,
                    'subject' => $class->subject->subject,
                    'teacher' => $class->teacher->user->full_name,
                    'grade' => $class->grade->grade,
                    'year' => $class->year,
                    'status' => $class->status_text,
                    'status_badge' => $this->getStatusBadge($class->status),
                    'created_date' => $class->created_at->format('Y-m-d'),
                    'action' => $this->generateActionButtons($class->id, $class->status)
                ];
            });
        } catch (Exception $e) {
            Log::error('Error fetching classes: ' . $e->getMessage());
            throw new Exception('Failed to fetch classes');
        }
    }

    public function createClass(array $data)
    {
        try {
            DB::beginTransaction();

            // Check if class already exists
            if ($this->classRepository->checkClassExists(
                $data['class_name'],
                $data['subjects_id'],
                $data['year']
            )) {
                throw new Exception('A class with this name, subject, and year already exists');
            }

            $class = $this->classRepository->create($data);


            DB::commit();
            return $class;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating class: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function updateClass(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $oldClass = $this->classRepository->getClassWithRelations($id);
            if (!$oldClass) {
                throw new Exception('Class not found');
            }

            // Check if class already exists (excluding current class)
            if ($this->classRepository->checkClassExists(
                $data['class_name'],
                $data['subjects_id'],
                $data['year'],
                $id
            )) {
                throw new Exception('A class with this name, subject, and year already exists');
            }

            $this->classRepository->update($id, $data);
            $newClass = $this->classRepository->getClassWithRelations($id);


            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating class: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getClassForEdit(int $id)
    {
        try {
            return $this->classRepository->getClassWithRelations($id);
        } catch (Exception $e) {
            Log::error('Error fetching class for edit: ' . $e->getMessage());
            throw new Exception('Failed to fetch class data');
        }
    }

    public function activateClass(int $id)
    {
        try {
            $result = $this->classRepository->changeStatus($id, true);

            return $result;
        } catch (Exception $e) {
            Log::error('Error activating class: ' . $e->getMessage());
            throw new Exception('Failed to activate class');
        }
    }

    public function deactivateClass(int $id)
    {
        try {
            $result = $this->classRepository->changeStatus($id, false);

            return $result;
        } catch (Exception $e) {
            Log::error('Error deactivating class: ' . $e->getMessage());
            throw new Exception('Failed to deactivate class');
        }
    }

    public function deleteClass(int $id)
    {
        try {
            DB::beginTransaction();

            $class = $this->classRepository->getClassWithRelations($id);
            if (!$class) {
                throw new Exception('Class not found');
            }

            $this->classRepository->delete($id);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting class: ' . $e->getMessage());
            throw new Exception('Failed to delete class');
        }
    }

    public function getTeacherClasses(int $teacherId)
    {
        try {
            return $this->classRepository->getClassesByTeacher($teacherId);
        } catch (Exception $e) {
            Log::error('Error fetching teacher classes: ' . $e->getMessage());
            throw new Exception('Failed to fetch teacher classes');
        }
    }

    private function getStatusBadge(bool $status): string
    {
        return $status
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }

    private function generateActionButtons(int $classId, bool $status): string
    {
        $editBtn = '<button class="btn btn-sm btn-primary me-1 edit-class" data-id="' . $classId . '" title="Edit">
                        <i class="icon-pencil-alt"></i>
                    </button>';



        $deleteBtn = '<button class="btn btn-sm btn-warning delete-class" data-id="' . $classId . '" title="Delete">
                          <i class="icon-trash"></i>
                      </button>';

        return $editBtn . $deleteBtn;
    }
}
