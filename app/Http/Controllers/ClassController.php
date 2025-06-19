<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\ClassService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index()
    {
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $grades = Grade::all();
        $years = $this->getAvailableYears();


        return view('pages.admin.classes.index', compact('subjects', 'teachers', 'grades', 'years'));
    }

    public function loadClasses(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['status', 'year', 'grade_id', 'subject_id', 'teacher_id']);
            $classes = $this->classService->getClassesWithFilters($filters);

            return response()->json($classes);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(CreateClassRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['status'] = $request->boolean('status', true);

            $this->classService->createClass($data);

            return response()->json([
                'success' => true,
                'message' => 'Class created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $class = $this->classService->getClassForEdit($request->id);

            if (!$class) {
                return response()->json(['error' => 'Class not found'], 404);
            }

            return response()->json(['class' => $class]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateClassRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $classId = $data['class_id'];
            unset($data['class_id']);

            $data['status'] = $request->boolean('status', true);

            $this->classService->updateClass($classId, $data);

            return response()->json([
                'success' => true,
                'message' => 'Class updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function activate(int $id): JsonResponse
    {
        try {
            $this->classService->activateClass($id);

            return response()->json([
                'success' => true,
                'message' => 'Class activated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deactivate(int $id): JsonResponse
    {
        try {
            $this->classService->deactivateClass($id);

            return response()->json([
                'success' => true,
                'message' => 'Class deactivated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->classService->deleteClass($id);

            return response()->json([
                'success' => true,
                'message' => 'Class deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTeacherClasses(Request $request): JsonResponse
    {
        try {
            $teacherId = $request->teacher_id;
            $classes = $this->classService->getTeacherClasses($teacherId);

            return response()->json($classes);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getAvailableYears(): array
    {
        $currentYear = date('Y');
        $years = [];

        for ($i = $currentYear - 2; $i <= $currentYear + 3; $i++) {
            $years[$i] = $i;
        }

        return $years;
    }
}
