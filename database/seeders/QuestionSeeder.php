<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop over existing exams
        Exam::with('teacher')->get()->each(function ($exam) {
            $teacherId = $exam->teacher_id;

            // 5–10 Multiple choice
            $mcQuestions = Question::factory()
                ->count(rand(5, 10))
                ->state([
                    'exam_id' => $exam->id,
                    'teacher_id' => $teacherId,
                    'type' => 'multiple_choice',
                ])
                ->create();

            // Each multiple choice has 4 options
            $mcQuestions->each(function ($question) {
                foreach (range(1, 4) as $i) {
                    Option::factory()->create([
                        'question_id' => $question->id,
                        'label' => $i,
                        'option' => fake()->sentence(5),
                    ]);
                }
            });

            // 3–5 Essay questions
            Question::factory()
                ->count(rand(3, 5))
                ->state([
                    'exam_id' => $exam->id,
                    'teacher_id' => $teacherId,
                    'type' => 'essay',
                ])
                ->create();
        });
    }
}
