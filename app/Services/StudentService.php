<?php

namespace App\Services;

use App\Repositories\Contracts\StudentRepositoryInterface;
use App\Repositories\Contracts\StudentClassRepositoryInterface;
use App\Services\QRCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class StudentService
{
    protected $studentRepository;
    protected $studentClassRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
        StudentClassRepositoryInterface $studentClassRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->studentClassRepository = $studentClassRepository;
    }

    public function getStudentsWithFilters(array $filters = [])
    {
        try {
            $students = $this->studentRepository->getAllWithFilters($filters);

            return $students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'student_id' => $student->student_id,
                    'name' => $student->full_name,
                    'email' => $student->email,
                    'contact_no' => $student->contact_no,
                    'parent_contact_no' => $student->parent_contact_no,
                    'nic' => $student->nic,
                    'classes_count' => $student->classes->count(),
                    'classes' => $student->classes->pluck('class_name')->join(', '),
                    'created_date' => $student->created_at->format('Y-m-d'),
                    'action' => $this->generateActionButtons($student->id)
                ];
            });
        } catch (Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());
            throw new Exception('Failed to fetch students');
        }
    }

    public function createStudent(array $data)
    {
        try {
            DB::beginTransaction();

            $student = $this->studentRepository->create($data);

            DB::commit();
            return $student;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating student: ' . $e->getMessage());
            throw new Exception('Failed to create student');
        }
    }

    public function updateStudent(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $oldStudent = $this->studentRepository->getStudentWithClasses($id);
            if (!$oldStudent) {
                throw new Exception('Student not found');
            }

            $this->studentRepository->update($id, $data);
            $newStudent = $this->studentRepository->getStudentWithClasses($id);


            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating student: ' . $e->getMessage());
            throw new Exception('Failed to update student');
        }
    }

    public function enrollStudentToClasses(int $studentId, array $classIds)
    {
        try {
            DB::beginTransaction();

            $this->studentClassRepository->enrollStudent($studentId, $classIds);


            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error enrolling student to classes: ' . $e->getMessage());
            throw new Exception('Failed to enroll student to classes');
        }
    }

    public function getStudentForEdit(int $id)
    {
        try {
            return $this->studentRepository->getStudentWithClasses($id);
        } catch (Exception $e) {
            Log::error('Error fetching student for edit: ' . $e->getMessage());
            throw new Exception('Failed to fetch student data');
        }
    }

    public function getStudentProfile(int $id)
    {
        try {
            $student = $this->studentRepository->getStudentWithClasses($id);
            if (!$student) {
                throw new Exception('Student not found');
            }

            return [
                'student' => $student,
                'classes' => $this->studentClassRepository->getStudentClasses($id),
                'qr_code_data' => $student->qr_code_data
            ];
        } catch (Exception $e) {
            Log::error('Error fetching student profile: ' . $e->getMessage());
            throw new Exception('Failed to fetch student profile');
        }
    }

    public function activateStudent(int $id)
    {
        try {
            $result = $this->studentRepository->changeStatus($id, true);


            return $result;
        } catch (Exception $e) {
            Log::error('Error activating student: ' . $e->getMessage());
            throw new Exception('Failed to activate student');
        }
    }

    public function deactivateStudent(int $id)
    {
        try {
            $result = $this->studentRepository->changeStatus($id, false);

            return $result;
        } catch (Exception $e) {
            Log::error('Error deactivating student: ' . $e->getMessage());
            throw new Exception('Failed to deactivate student');
        }
    }

    public function deleteStudent(int $id)
    {
        try {
            DB::beginTransaction();

            $student = $this->studentRepository->getStudentWithClasses($id);
            if (!$student) {
                throw new Exception('Student not found');
            }

            // Soft delete by setting status to 0
            $this->studentRepository->delete($id);

            // Also deactivate all class enrollments
            $studentClasses = $this->studentClassRepository->getStudentClasses($id, false);
            foreach ($studentClasses as $enrollment) {
                $this->studentClassRepository->updateEnrollmentStatus(
                    $id,
                    $enrollment->classes_id,
                    false
                );
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting student: ' . $e->getMessage());
            throw new Exception('Failed to delete student');
        }
    }

    public function searchStudents(string $search)
    {
        try {
            return $this->studentRepository->searchStudents($search);
        } catch (Exception $e) {
            Log::error('Error searching students: ' . $e->getMessage());
            throw new Exception('Failed to search students');
        }
    }

    private function generateActionButtons(int $studentId): string
    {
        $viewBtn = '<a href="/admin/students/profile/' . $studentId . '" class="btn btn-xs btn-info me-1" title="View Profile">
                        <i class="bi bi-eye"></i>
                    </a>';

        $editBtn = '<a href="/admin/students/edit/' . $studentId . '" class="btn btn-xs btn-primary me-1" title="Edit">
                         <i class="icon-pencil-alt"></i>
                    </a>';

        $deleteBtn = '<button class="btn btn-xs btn-danger delete-student" data-id="' . $studentId . '" title="Delete">
                          <i class="icon-trash"></i>
                      </button>';

        return $viewBtn . $editBtn . $deleteBtn;
    }
}
