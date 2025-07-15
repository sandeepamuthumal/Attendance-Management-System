<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition()
    {
        return [
            'users_id' => User::factory(),
            'subjects_id' => Subject::factory(),
            'contact_no' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'nic' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

   

    public function withUser($userId)
    {
        return $this->state(function (array $attributes) use ($userId) {
            return [
                'users_id' => $userId,
            ];
        });
    }
}
