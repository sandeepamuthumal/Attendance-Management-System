<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeService
{
    public static function generateStudentQR($student): bool
    {
        $qrData = json_encode([
            'type' => 'student',
            'student_id' => $student->student_id,
            'name' => $student->full_name,
            'email' => $student->email,
            'generated_at' => now()->toISOString()
        ]);

        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate($qrData);

        $filename = $student->student_id . '.png';

        $filePath = public_path('qrcodes/' . $filename);

        // Ensure the directory exists before saving
        if (!file_exists(public_path('qrcodes'))) {
            mkdir(public_path('qrcodes'), 0755, true);
        }

        // Store the QR code image in the public folder
        file_put_contents($filePath, $qrCode);

        return true;
    }

    public static function generateStudentQRBase64($student): string
    {
        $qrData = json_encode([
            'type' => 'student',
            'student_id' => $student->student_id,
            'name' => $student->full_name,
            'email' => $student->email,
            'generated_at' => now()->toISOString()
        ]);

        return QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate($qrData);
    }
}
