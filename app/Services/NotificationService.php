<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
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
}
