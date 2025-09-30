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
            ['subject' => 'Mathematics', 'subject_code' => 'MATH101'],
            ['subject' => 'English', 'subject_code' => 'ENG101'],
            ['subject' => 'Science', 'subject_code' => 'SCI101'],
            ['subject' => 'History', 'subject_code' => 'HIS101'],
            ['subject' => 'ICT', 'subject_code' => 'CS101']
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
