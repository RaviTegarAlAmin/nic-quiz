<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Teaching;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamAssignment>
 */
class ExamAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('+1 days', '+7 days');
        $endAt = (clone $startAt)->modify('+2 hours');

        return [
            'exam_id' => Exam::inRandomOrder()->first()->id ?? Exam::factory(),
            'teaching_id' => Teaching::inRandomOrder()->first()->id ?? Teaching::factory(),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'duration' => 120,
            'status' => $this->faker->randomElement(['on_hold', 'ongoing', 'finished', 'not_started']),
        ];

    }
}
