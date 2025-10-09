<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function sendTeacherCredentials(User $user, string $password)
    {
        try {
            $data['teacher'] = $user;
            $data['password'] = $password;

            Mail::send('email/teacher-credentials', $data, function ($messages) use ($data) {
                $messages->to($data['teacher']->email);
                $messages->subject("Welcome to Bright Educational Center");
            });

            Log::info("Credentials email sent to teacher: {$data['teacher']->email}");
            return true;
        } catch (\Throwable $th) {
            Log::error("Failed to send teacher credentials: " . $th->getMessage());
            return false;
        }
    }

    public function sendStudentQRCode(Student $student)
    {
        try {
            $profileData = $this->studentService->getStudentProfile($student->id);
            $data['student'] = $profileData['student'];
            $data['classes'] = $profileData['classes'];

            $fileName = $data['student']->student_id . '.png';
            $filePath = public_path('qrcodes/' . $fileName);

            Mail::send('email/student-profile', $data, function ($messages) use ($data, $filePath) {
                $messages->to($data['student']->email);
                $messages->subject("Your Attendance QR Code");
                $messages->attach($filePath);
            });

            Log::info("QR code email sent to student: {$data['student']->email}");
            return true;
        } catch (\Throwable $th) {
            Log::error("Failed to send student QR code: " . $th->getMessage());
            throw new Exception('Failed to send student QR code');
        }
    }
}
