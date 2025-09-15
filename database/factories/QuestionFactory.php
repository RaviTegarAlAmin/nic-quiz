<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(), // overridden in seeder
            'teacher_id' => Teacher::factory(), // overridden in seeder
            'question' => $this->faker->sentence(12),
            'type' => $this->faker->randomElement(['multiple_choice', 'essay']),
            'weight' => $this->faker->numberBetween(1, 5),
            'ref_answer' => $this->faker->boolean(70) ? $this->faker->sentence(15) : null,
            'ref_answer_embed' => null,
        ];
    }
}
