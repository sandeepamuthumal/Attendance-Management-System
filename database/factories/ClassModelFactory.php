<?php

namespace Database\Factories;

use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassModelFactory extends Factory
{
    protected $model = ClassModel::class;

    public function definition()
    {
        $classTypes = ['A', 'B', 'C', 'D', 'Advanced', 'Basic', 'Special'];

        return [
            'class_name' => 'Class ' . $this->faker->randomElement($classTypes) . ' ' . $this->faker->numberBetween(1, 20),
            'subjects_id' => Subject::factory(),
            'grades_id' => Grade::factory(),
            'teachers_id' => Teacher::factory(),
            'year' => $this->faker->numberBetween(2025, 2028),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withExistingSubjectAndGrade($subjectId = null, $gradeId = null)
    {
        return $this->state(function (array $attributes) use ($subjectId, $gradeId) {
            return [
                'subjects_id' => $subjectId ?? Subject::factory(),
                'grades_id' => $gradeId ?? Grade::factory(),
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 0,
            ];
        });
    }

    public function mathematics()
    {
        return $this->state(function (array $attributes) {
            return [
                'subjects_id' => Subject::factory()->create(['subject' => 'Mathematics'])->id,
                'class_name' => 'Mathematics Class ' . $this->faker->randomElement(['A', 'B', 'C']),
            ];
        });
    }

    public function physics()
    {
        return $this->state(function (array $attributes) {
            return [
                'subjects_id' => Subject::factory()->create(['subject' => 'Physics'])->id,
                'class_name' => 'Physics Class ' . $this->faker->randomElement(['A', 'B', 'C']),
            ];
        });
    }
}
