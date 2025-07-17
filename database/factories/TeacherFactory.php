<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->randomNumber('9', true),
            'gender' => fake()->randomElement(['Laki-Laki', 'Perempuan']),
            'born_date' => fake()->dateTimeBetween('-65 years', '-22 years'),
            'address' => fake()->address()
        ];
    }
}
