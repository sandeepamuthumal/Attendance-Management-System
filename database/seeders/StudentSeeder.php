<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Resolve your service via the container
        $studentService = App::make(\App\Services\StudentService::class);

        for ($i = 1; $i <= 20; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $email = strtolower($firstName . '.' . $lastName . $i . '@demo.com');

            $data = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'contact_no' => '07' . rand(10000000, 99999999),
                'parent_contact_no' => '07' . rand(10000000, 99999999),
                'email' => $email,
                'nic' => strtoupper(Str::random(8)) . 'V',
                'address' => fake()->address(),
                'status' => 1,
            ];

            // Randomly assign 1–3 class IDs for demo
            $classIds = collect([1, 2, 3, 4, 5])
                ->shuffle()
                ->take(rand(1, 3))
                ->toArray();

            // Create student
            $student = $studentService->createStudent($data);

            // Generate QR code
            \App\Services\QRCodeService::generateStudentQR($student);

            // Enroll into classes
            $studentService->enrollStudentToClasses($student->id, $classIds);
        }

        $this->command->info('20 demo students created successfully!');
    }
}
