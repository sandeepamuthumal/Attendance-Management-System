<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\StudentHasClass;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Grade;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class AttendanceTest extends TestCase
{

    protected $attendanceService;
    protected $student;
    protected $class;
    protected $enrollment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->attendanceService = app(AttendanceService::class);

        // Create test data
        $this->student = Student::factory()->create([
            'student_id' => 'STU001',
            'status' => 1
        ]);

        $subject = Subject::factory()->create(['subject' => 'Mathematics']);
        $grade = Grade::factory()->create(['grade' => 'Grade 10']);

        $this->class = ClassModel::factory()->create([
            'class_name' => 'Math Class A',
            'subject_id' => $subject->id,
            'grade_id' => $grade->id
        ]);

        $this->enrollment = StudentHasClass::factory()->create([
            'students_id' => $this->student->id,
            'classes_id' => $this->class->id,
            'status' => 1
        ]);
    }

    public function test_can_validate_and_load_student()
    {
        $result = $this->attendanceService->validateAndLoadStudent(
            $this->student->student_id,
            $this->class->id,
            Carbon::today()->format('Y-m-d')
        );

        $this->assertEquals($this->student->id, $result['student']->id);
        $this->assertEquals($this->enrollment->id, $result['enrollment']->id);
    }

    public function test_throws_exception_for_non_existent_student()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Student not found');

        $this->attendanceService->validateAndLoadStudent(
            'INVALID_ID',
            $this->class->id,
            Carbon::today()->format('Y-m-d')
        );
    }

    public function test_throws_exception_for_non_enrolled_student()
    {
        $otherStudent = Student::factory()->create([
            'student_id' => 'STU002',
            'status' => 1
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Student is not enrolled in the selected class');

        $this->attendanceService->validateAndLoadStudent(
            $otherStudent->student_id,
            $this->class->id,
            Carbon::today()->format('Y-m-d')
        );
    }

    public function test_can_mark_attendance()
    {
        $result = $this->attendanceService->markAttendance(
            $this->student->id,
            $this->enrollment->id,
            Carbon::today()->format('Y-m-d')
        );

        $this->assertTrue($result);
        $this->assertDatabaseHas('attendances', [
            'students_id' => $this->student->id,
            'students_has_classes_id' => $this->enrollment->id,
        ]);
    }

    public function test_throws_exception_for_duplicate_attendance()
    {
        // Mark attendance first time
        $this->attendanceService->markAttendance(
            $this->student->id,
            $this->enrollment->id,
            Carbon::today()->format('Y-m-d')
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Student has already been marked present');

        // Try to mark again
        $this->attendanceService->validateAndLoadStudent(
            $this->student->student_id,
            $this->class->id,
            Carbon::today()->format('Y-m-d')
        );
    }

    public function test_can_get_attendance_stats()
    {
        // Create additional students
        $student2 = Student::factory()->create(['status' => 1]);
        $student3 = Student::factory()->create(['status' => 1]);

        StudentHasClass::factory()->create([
            'students_id' => $student2->id,
            'classes_id' => $this->class->id,
            'status' => 1
        ]);

        StudentHasClass::factory()->create([
            'students_id' => $student3->id,
            'classes_id' => $this->class->id,
            'status' => 1
        ]);

        // Mark attendance for one student
        $this->attendanceService->markAttendance(
            $this->student->id,
            $this->enrollment->id,
            Carbon::today()->format('Y-m-d')
        );

        $stats = $this->attendanceService->getAttendanceStats(
            $this->class->id,
            Carbon::today()->format('Y-m-d')
        );

        $this->assertEquals(3, $stats['total']);
        $this->assertEquals(1, $stats['present']);
        $this->assertEquals(2, $stats['absent']);
    }
}
