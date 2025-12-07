<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentHasClass;
use App\Services\AttendanceService;
use App\Services\ClassService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendanceScanner extends Component
{
    public $classes;
    public $selected_date;
    public $selected_class;
    public $student;
    public $enrollment;
    public $output_value;

    public $totalStudents = 0;
    public $presentStudents = 0;

    protected $attendanceService;
    protected $classService;

    public $notifications = [];

    public function boot(AttendanceService $attendanceService, ClassService $classService)
    {
        $this->attendanceService = $attendanceService;
        $this->classService = $classService;
    }

    #[On('echo:attendance-channel,AttendanceMarked')]
    public function handleAttendanceEvent($payload)
    {
        $this->notifications[] = "{$payload['student_name']} marked attendance at {$payload['time']}";

        $student = $payload['student_name'];
        $time = $payload['time'];

        // Dispatch event to frontend
        $this->dispatch('attendance-notification', [
            'student' => $student,
            'time' => $time,
        ]);
    }

    public function changeClass($classId)
    {
        $this->selected_class = $classId;
        $this->resetStudentData();
    }

    public function loadStats()
    {
        $this->resetStats();

        if (!$this->selected_class) {
            return;
        }

        try {
            $stats = $this->attendanceService->getAttendanceStats(
                $this->selected_class,
                $this->selected_date
            );

            $this->totalStudents = $stats['total'];
            $this->presentStudents = $stats['present'];
        } catch (\Exception $e) {
            Log::error('Failed to load attendance stats: ' . $e->getMessage());
            $this->dispatch('showError', 'Failed to load statistics');
        }
    }

    public function loadStudent($studentId)
    {
        if (!$this->selected_class) {
            $this->dispatch('showError', 'Please select a class first');
            return;
        }

        if (empty($studentId)) {
            $this->dispatch('showError', 'Please scan a QR code or enter a Student ID');
            return;
        }

        try {
            $result = $this->attendanceService->validateAndLoadStudent(
                $studentId,
                $this->selected_class,
                $this->selected_date
            );

            $this->student = $result['student'];
            $this->enrollment = $result['enrollment'];

            $this->dispatch('openStudentModal');
        } catch (\Exception $e) {
            Log::error('Failed to load student: ' . $e->getMessage());
            $this->dispatch('showError', $e->getMessage());
        }
    }

    public function markAttendance()
    {
        if (!$this->student || !$this->enrollment) {
            $this->dispatch('showError', 'No student selected');
            return;
        }

        try {
            $this->attendanceService->markAttendance(
                $this->student->id,
                $this->enrollment->id,
                $this->selected_date
            );

            $this->dispatch('showSuccess', 'Attendance marked successfully');
            $this->resetStudentData();
            $this->loadStats(); // Refresh stats after marking attendance
        } catch (\Exception $e) {
            Log::error('Failed to mark attendance: ' . $e);
            $this->dispatch('showError', $e->getMessage());
        }
    }

    public function mount()
    {
        $this->classes = $this->classService->getAllClasses();
        $this->selected_date = Carbon::today()->format('Y-m-d');
        $this->resetStats();
    }

    public function render()
    {
        $this->loadStats();
        return view('livewire.attendance-scanner');
    }

     private function resetStudentData()
    {
        $this->student = null;
        $this->enrollment = null;
        $this->output_value = '';
    }

    private function resetStats()
    {
        $this->totalStudents = 0;
        $this->presentStudents = 0;
    }

    // Validation rules
    protected $rules = [
        'selected_class' => 'required|integer|exists:classes,id',
        'selected_date' => 'required|date',
        'output_value' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'selected_class.required' => 'Please select a class',
        'selected_date.required' => 'Please select a date',
    ];
}
