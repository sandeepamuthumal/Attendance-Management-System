<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\ClassModel;
use App\Models\Grade;
use App\Models\Subject;
use App\Services\StudentService;
use App\Services\QRCodeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Display students list page
     */
    public function index()
    {
        $classes = ClassModel::with(['subject', 'grade'])->active()->get();
        return view('pages.admin.students.index', compact('classes'));
    }

    public function teachertudents()
    {
        $classes = ClassModel::with(['subject','grade'])->active()->get();
        return view('pages.teacher.students', compact('classes'));
    }

    /**
     * Show create student form
     */
    public function create()
    {
        $classes = ClassModel::with(['subject', 'teacher.user', 'grade'])->active()->get();
        $grades = Grade::all();
        $subjects = Subject::all();

        return view('pages.admin.students.create', compact('classes', 'grades', 'subjects'));
    }

    /**
     * Store new student
     */
    public function store(CreateStudentRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $classIds = $data['class_ids'] ?? [];
            unset($data['class_ids']);

            $student = $this->studentService->createStudent($data);

            // Generate QR code
            QRCodeService::generateStudentQR($student);

            // Enroll to classes if provided
            if (!empty($classIds)) {
                $this->studentService->enrollStudentToClasses($student->id, $classIds);
            }

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'student_id' => $student->student_id,
                'redirect' => route('admin.students.profile', $student->id)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Show edit student form
     */
    public function edit(int $id)
    {
        try {
            $student = $this->studentService->getStudentForEdit($id);

            if (!$student) {
                abort(404, 'Student not found');
            }

            $classes = ClassModel::with(['subject', 'teacher.user', 'grade'])->active()->get();
            $grades = Grade::all();
            $subjects = Subject::all();

            $enrolledClassIds = $student->classes->pluck('id')->toArray();



            return view('pages.admin.students.edit', compact('student', 'classes', 'grades', 'subjects', 'enrolledClassIds'));
        } catch (Exception $e) {
            abort(404, 'Student not found');
        }
    }

    /**
     * Update student
     */
    public function update(UpdateStudentRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $studentId = $data['student_id'];
            $classIds = $data['class_ids'] ?? [];
            unset($data['student_id'], $data['class_ids']);

            $this->studentService->updateStudent($studentId, $data);

            // Update class enrollments
            if (isset($request->class_ids)) {
                $this->studentService->enrollStudentToClasses($studentId, $classIds);
            }

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'redirect' => route('admin.students.profile', $studentId)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Show student profile
     */
    public function profile(int $id)
    {
        try {
            $profileData = $this->studentService->getStudentProfile($id);
            return view('pages.admin.students.profile', $profileData);
        } catch (Exception $e) {
            abort(404, 'Student not found');
        }
    }

    /**
     * Load students with filters (AJAX)
     */
    public function loadStudents(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['search', 'class_id']);
            $students = $this->studentService->getStudentsWithFilters($filters);

            return response()->json($students);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Search students (AJAX)
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->get('q', '');
            $students = $this->studentService->searchStudents($search);

            return response()->json($students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'text' => $student->student_id . ' - ' . $student->full_name,
                    'student_id' => $student->student_id,
                    'name' => $student->full_name,
                    'email' => $student->email
                ];
            }));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Activate student
     */
    public function activate(int $id): JsonResponse
    {
        try {
            $this->studentService->activateStudent($id);
            return response()->json([
                'success' => true,
                'message' => 'Student activated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deactivate student
     */
    public function deactivate(int $id): JsonResponse
    {
        try {
            $this->studentService->deactivateStudent($id);
            return response()->json([
                'success' => true,
                'message' => 'Student deactivated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Download student QR code
     */
    public function downloadQR(int $id): Response
    {
        try {
            $student = $this->studentService->getStudentForEdit($id);
            if (!$student) {
                abort(404, 'Student not found');
            }

            $qrCode = QRCodeService::generateStudentQRBase64($student);

            return response($qrCode)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="' . $student->student_id . '_qr.png"');
        } catch (Exception $e) {
            abort(500, 'Failed to generate QR code');
        }
    }

    /**
     * Get available classes for enrollment
     */
    public function getAvailableClasses(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['grade_id', 'subject_id']);
            $query = ClassModel::with(['subject', 'teacher.user', 'grade'])->active();

            if (!empty($filters['grade_id'])) {
                $query->where('grades_id', $filters['grade_id']);
            }

            if (!empty($filters['subject_id'])) {
                $query->where('subjects_id', $filters['subject_id']);
            }

            $classes = $query->get();

            return response()->json($classes->map(function ($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->class_name,
                    'subject' => $class->subject->subject,
                    'teacher' => $class->teacher->user->full_name,
                    'grade' => $class->grade->grade_name,
                    'year' => $class->year,
                    'full_name' => $class->class_name . ' - ' . $class->subject->subject . ' (' . $class->grade->grade_name . ')'
                ];
            }));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
