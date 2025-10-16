<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\ExamTaker;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamTaker::with('examAssignment.exam')->get()->each(function ($examTaker) {
            $questions = Question::where('exam_id', $examTaker->examAssignment->exam_id)->get();

            foreach ($questions as $question) {
                // ~20% chance to skip (answer=null)
                $shouldSkip = rand(0, 4) === 0;

                $answerText = null;

                if (!$shouldSkip) {
                    $answerText = $question->type === 'multiple_choice'
                        ? (string) fake()->numberBetween(1, 4)
                        : fake()->paragraph(3);
                }

                Answer::firstOrCreate(
                    [
                        'exam_taker_id' => $examTaker->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'answer' => $answerText,
                        'score' => null, // grading can happen later
                    ]
                );
            }
        });

    }
}
