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
            ['subject' => 'Commerce', 'subject_code' => 'COM101'],
            ['subject' => 'Social Studies', 'subject_code' => 'SOC101'],
            ['subject' => 'ET', 'subject_code' => 'ET101'],
            ['subject' => 'SFT', 'subject_code' => 'SFT101'],
            ['subject' => 'ICT', 'subject_code' => 'ICT101'],
            ['subject' => 'Accounting', 'subject_code' => 'ACC101'],
            ['subject' => 'Business Studies', 'subject_code' => 'BUS101'],
            ['subject' => 'Physics', 'subject_code' => 'PHY101'],
            ['subject' => 'Biology', 'subject_code' => 'BIO101'],
            ['subject' => 'Chemistry', 'subject_code' => 'CHE101'],
            ['subject' => 'Combined Mathematics', 'subject_code' => 'MATH102'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
