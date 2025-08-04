<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Exam;
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
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory(),
            'title' => $this->faker->sentence(4),
            'start_at' => $start,
            'end_at' => $end,
            'duration' => $this->faker->numberBetween(30, 120), // minutes
            'status' => $this->faker->randomElement(Exam::$status),
            'published' => false
        ];
    }
}
