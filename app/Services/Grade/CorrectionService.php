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

    private $batchedEssay = [];

    private $bulkUpdateEssay = [];

    private array $similarityScores = [];

    //just to check inputs and match the exam taker Id, dummy variables
    public array $dummy_inputs = [];

    public function __construct(
        private OpenAIEmbeddingService $openAIembedding,
        private CosineSimilarityService $cosineSimilarityService
    ) {

    }

    /* So in this function I iterate the correction based on exam taker. Meanwhile the fricking
    essay embedding service setted to evaluate answer base on question lmao. This decision consider RPM for openAI. It will be more efficient to call API per question-answer. Thus, I reactively
    adapt the essay correction part following the mcq correction structure. */


    public function correction(ExamAssignment $assignment)
    {
        $assignment = $assignment->load('examTakers.answers.question:id,ref_answer,type,weight');

        $exam = $assignment->exam->loadSum('questions as total_weight', 'weight');
        $exam = $exam->load('questions');

        $totalWeight = $exam->total_weight;

        $bulkUpdate = [];

        $bulkScore = [];



        //initialize bulk essay update

        foreach ($exam->questions as $question) {
            if (!isset($this->batchedEssay[$question->id]) && $question->type == 'essay') {
                $this->batchedEssay[$question->id][] = [
                    'ref_answer' => $question->ref_answer,
                    'weight' => $question->weight
                ];
            }
        }

        //=============================================================================
        //MCQ Part
        //=============================================================================


        foreach ($assignment->examTakers as $examTaker) {

            $totalScore = 0;

            //Getting each type of question per examTaker

            $essayAnswers = $examTaker->answers
                ->filter(fn($a) => $a->question->type === 'essay');

            $mcqAnswers = $examTaker->answers
                ->filter(fn($a) => $a->question->type === 'multiple_choice');

            //correction for multiple choice

            foreach ($mcqAnswers as $answer) {

                $question = $answer->question;
                $ref_answer = $question->ref_answer;

                $score = 0;

                if ($answer->answer != null) {
                    $score = $this->mcqCorrection($answer->answer, $ref_answer);
                }

                //Weighting and Adding to Total Score

                $score *= $question->weight;


                $totalScore += $score;

                //Updating every goddamn answer score for MCQ
                $bulkUpdate[] = [
                    'id' => $answer->id,
                    'question_id' => $question->id,
                    'exam_taker_id' => $examTaker->id,
                    'score' => $score,
                    'updated_at' => now()
                ];

            }


            //Updating mcq score for examtaker

            $totalScore = round(($totalScore * 100) / $totalWeight, 2);

            $bulkScore[] = [
                'exam_taker_id' => $examTaker->id,
                'exam_score' => $totalScore
            ];


            //Batching essay answers per examtaker

            foreach ($essayAnswers as $answer) {

                $this->batchedEssay[$answer->question_id][] = [
                    'id' => $answer->id,
                    'exam_taker_id' => $answer->examTaker->id,
                    'answer' => $answer->answer
                ];

            }


        }

        //=============================================================================
        //Essay Part
        //=============================================================================


        //Changing array structure for conviniency on updating the examtakerscore

        $bulkScoreByExamTaker = [];
        foreach ($bulkScore as $score) {
            $bulkScoreByExamTaker[$score['exam_taker_id']] = $score['exam_score'];
        }




        $this->essayCorrection($this->batchedEssay);

        //Adding score to existing mcq score

        foreach ($this->bulkUpdateEssay as $examTakerId => $updateEssays) {
            $essayScores = 0;
            foreach ($updateEssays as $essay) {
                $essayScores += $essay['score'];
                $bulkUpdate[] = [
                    'id' => $essay['id'],
                    'question_id' => $essay['question_id'],
                    'exam_taker_id' => $examTakerId,
                    'score' => $essay['score'],
                    'updated_at' => $essay['updated_at']
                ];
            }

            $essayScores = round(($essayScores * 100) / $totalWeight, 2);

            if (isset($bulkScoreByExamTaker[$examTakerId])) {
                $bulkScoreByExamTaker[$examTakerId] += $essayScores;
            } else {
                $bulkScoreByExamTaker[$examTakerId] = $essayScores;
            }

        }

        $bulkScore = [];
        foreach ($bulkScoreByExamTaker as $examTakerId => $score) {
            $bulkScore[] = [
                'exam_taker_id' => $examTakerId,
                'exam_score' => $score
            ];
        }

/*         dd($this->similarityScores, $this->batchedEssay, $this->bulkUpdateEssay, $bulkUpdate, $bulkScoreByExamTaker, $bulkScore);

 */
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

    protected function essayCorrection(array $batchedEssay)
    {
        //Extracting batchedEssay data to for inputs


        foreach ($batchedEssay as $questionId => $essayAnswerPerQuestion) {

            //mapping ref_answer and student answer

            $ref = array_shift($essayAnswerPerQuestion);

            $ref_answer = $ref['ref_answer'];

            $inputs = array_map(fn($a) => $a['answer'], $essayAnswerPerQuestion);

            $inputs = array_merge([$ref_answer], $inputs);

            $this->dummy_inputs[] = $inputs;

            //embedding per question

            $embeddingsPerQuestion = $this->openAIembedding->embedding($inputs);

            //cosine similarity evaluation returning score of similarity

            $this->similarityScores[] = $this->cosineSimilarityService->similarity($embeddingsPerQuestion);

        }


        $this->mapSimilarityScoresToBulkUpdate();


    }

    private function mapSimilarityScoresToBulkUpdate()
    {


        $row_index = 0;

        //looping for every batched essay per questions
        foreach ($this->batchedEssay as $questionId => $essayAnswers) {


            //separating first element which is ref answer and weight
            $questionData = array_shift($essayAnswers);


            //looping the rest of essay Answer
            foreach ($essayAnswers as $index => $essayAnswer) {
                $essayAnswer['score'] = $this->similarityScores[$row_index][$index] * $questionData['weight'];
                $this->bulkUpdateEssay[$essayAnswer['exam_taker_id']][] = [
                    'id' => $essayAnswer['id'],
                    'question_id' => $questionId,
                    'score' => $essayAnswer['score'],
                    'updated_at' => now()
                ];
            }

            $row_index += 1;
        }

    }


}
