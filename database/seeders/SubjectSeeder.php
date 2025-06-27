<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['subject' => 'Mathematics', 'subject_code' => 'MATH101', 'description' => 'Basic Mathematics'],
            ['subject' => 'English', 'subject_code' => 'ENG101', 'description' => 'English Language'],
            ['subject' => 'Science', 'subject_code' => 'SCI101', 'description' => 'General Science'],
            ['subject' => 'History', 'subject_code' => 'HIS101', 'description' => 'World History'],
            ['subject' => 'Computer Science', 'subject_code' => 'CS101', 'description' => 'Introduction to Programming']
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
