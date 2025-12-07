<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\StudentHasClass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition()
    {
        return [
            'students_id' => Student::factory(),
            'students_has_classes_id' => StudentHasClass::factory(),
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
        ];
    }

    public function today()
    {
        return $this->state(function (array $attributes) {
            return [
                'date' => Carbon::today()->format('Y-m-d'),
            ];
        });
    }

    public function yesterday()
    {
        return $this->state(function (array $attributes) {
            return [
                'date' => Carbon::yesterday()->format('Y-m-d'),
            ];
        });
    }
}
