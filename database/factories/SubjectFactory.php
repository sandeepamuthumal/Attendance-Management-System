<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition()
    {
        $subjects = [
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biology',
            'English',
            'History',
            'Geography',
            'Computer Science',
            'Economics',
            'Accounting',
            'Business Studies',
            'Art',
            'Music',
            'Physical Education',
            'Science'
        ];

        return [
            'subject' => $this->faker->unique()->randomElement($subjects),
            'description' => $this->faker->sentence(10),
            'subject_code' => $this->faker->unique()->numberBetween(1000, 9999),
        ];
    }

    public $timestamps = false;
}
