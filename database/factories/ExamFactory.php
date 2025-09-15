<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 week');
        $end = (clone $start)->modify('+2 hours');

        return [
            'teacher_id' => Teacher::inRandomOrder()->first()->id ?? Teacher::factory(),
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory(),
            'title' => $this->faker->sentence(3),
        ];
    }
}
