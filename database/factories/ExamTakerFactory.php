<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamTaker>
 */
class ExamTakerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                        'last_active_at' => now(),
            'start_at' => now(),
            'finished_at' => null,
            'status' => 'ongoing',
            'duration_used' => 0,
        ];
    }
}
