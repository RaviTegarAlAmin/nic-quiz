<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Exam::with('teacher')->get()->each(function ($exam) {
            $teacherId = $exam->teacher_id;

            // --- Multiple Choice Questions ---
            $mcQuestions = Question::factory()
                ->count(rand(5, 10))
                ->state([
                    'exam_id' => $exam->id,
                    'teacher_id' => $teacherId,
                    'type' => 'multiple_choice',
                ])
                ->make() // don't persist yet, need to set ref_answer
                ->each(function ($question) use ($exam, $teacherId) {
                    $question->save();

                    // Create 4 options
                    $labels = range(1, 4);
                    foreach ($labels as $i) {
                        Option::factory()->create([
                            'question_id' => $question->id,
                            'label' => (string) $i,
                            'option' => fake()->sentence(5),
                        ]);
                    }

                    // Pick one correct label (1–4) as ref_answer
                    $question->ref_answer = (string) fake()->numberBetween(1, 4);
                    $question->save();
                });

            // --- Essay Questions ---
            Question::factory()
                ->count(rand(3, 5))
                ->state([
                    'exam_id' => $exam->id,
                    'teacher_id' => $teacherId,
                    'type' => 'essay',
                    'ref_answer' => fake()->paragraph(3),
                ])
                ->create();
        });
    }
}
