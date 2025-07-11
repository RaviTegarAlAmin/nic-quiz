<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->numberBetween(00000000,999999999),
            'born_date' => fake()->dateTimeBetween('-14 years', '-12 years'),
            'address' => fake()->address()

        ];
    }
}
