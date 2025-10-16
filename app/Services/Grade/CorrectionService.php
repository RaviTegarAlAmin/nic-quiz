<?php

namespace App\Services\Grade;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use App\Models\Grade;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class CorrectionService
{


    public function correction(ExamAssignment $assignment)
    {
        $assignment = $assignment->load('examTakers.answers.question:id,ref_answer,type,weight');

        $exam = $assignment->exam->loadSum('questions as total_weight', 'weight');

        $totalWeight = $exam->total_weight;

        $bulkUpdate = [];

        $bulkScore = [];

        foreach ($assignment->examTakers as $examTaker) {

            $totalScore = 0;


            foreach ($examTaker->answers as $answer) {

                $question = $answer->question;
                $ref_answer = $question->ref_answer;

                $score = 0;

                //Checking question type

                if ($question->type == 'multiple_choice' && $answer->answer != null) {
                    $score = $this->mcqCorrection($answer->answer, $ref_answer);
                } elseif ($question->type == 'essay' && $answer->answer != null) {
                    $score = $this->essayCorrection($answer->answer, $ref_answer);
                }

                //Weighting and Adding to Total Score

                $score *= $question->weight;


                $totalScore += $score;

                //Updating every goddamn answer score
                $bulkUpdate[] = [
                    'id' => $answer->id,
                    'exam_taker_id' => $examTaker->id,
                    'question_id' => $question->id,
                    'score' => $score,
                    'updated_at' => now()
                ];

            }

            //Updating score for examtaker

            $totalScore = round(($totalScore*100)/$totalWeight,2);

            $bulkScore[] = [
                'exam_taker_id' => $examTaker->id,
                'exam_score' => $totalScore
            ];

        }


        if ($bulkUpdate != null) {

            DB::transaction(function () use ($bulkUpdate, $bulkScore) {
                Answer::upsert(
                    $bulkUpdate,
                    ['id'],
                    ['score', 'updated_at']
                );

                Grade::upsert(
                    $bulkScore,
                    ['exam_taker_id'],
                    ['exam_score']
                );

            });

        }


    }

    protected function mcqCorrection(string $answer, string $ref_answer)
    {
        return $answer == $ref_answer ? 1 : 0;
    }

    protected function essayCorrection(string $answer, string $ref_answer)
    {
        return 1;
    }



}
