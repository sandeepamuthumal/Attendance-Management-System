<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentHasClass;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceScanner extends Component
{
    public $classes;
    public $selected_date;
    public $selected_class,$student,$enrollment;

    public $totalStudents = 0;
    public $presentStudents = 0;

    public function changeClass($class_id)
    {
        $this->selected_class = $class_id;
    }

    public function loadStats()
    {
        $this->totalStudents = 0;
        $this->presentStudents = 0;

        if ($this->selected_class) {
           $this->totalStudents = StudentHasClass::where('classes_id', $this->selected_class)->where('status',1)->count();
           $this->presentStudents = Attendance::leftJoin('students_has_classes', 'attendances.students_has_classes_id', '=', 'students_has_classes.id')
                ->where('students_has_classes.classes_id', $this->selected_class)
                ->whereDate('attendances.date', Carbon::today())
                ->count();
        }
    }

    public function loadStudent($student_id)
    {
        $this->student = Student::where('student_id', $student_id)->where('status', 1)->first();
        if (!$this->student) {
            $this->dispatch('showError', 'Student not found');
            return;
        }

        // Check if the student is enrolled in the selected class
        $this->enrollment = StudentHasClass::where('students_id', $this->student->id)
            ->where('classes_id', $this->selected_class)
            ->where('status', 1)
            ->first();

        if (!$this->enrollment) {
            $this->dispatch('showError', 'Student is not enrolled in the selected class');
            return;
        }

        // Check if the student has already been marked present selected_date
        $attendance = Attendance::where('students_id', $this->student->id)
            ->where('students_has_classes_id', $this->enrollment->id)
            ->whereDate('date',  $this->selected_date)
            ->first();

        if ($attendance) {
            $this->dispatch('showError', 'Student has already been marked present');
            return;
        }

        $this->dispatch('openStudentModal');
    }

    public function markAttendance()
    {
        if (!$this->student || !$this->enrollment) {
            $this->dispatch('showError', 'No student selected');
            return;
        }

        // Create attendance record
        Attendance::create([
            'students_id' => $this->student->id,
            'students_has_classes_id' => $this->enrollment->id,
            'date' => $this->selected_date,
        ]);

        $this->dispatch('showSuccess', 'Attendance marked successfully');
    }

    public function mount()
    {
        $this->classes = ClassModel::with(['subject', 'teacher.user', 'grade'])->get();
        $this->selected_date = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        $this->loadStats();
        return view('livewire.attendance-scanner');
    }
}
