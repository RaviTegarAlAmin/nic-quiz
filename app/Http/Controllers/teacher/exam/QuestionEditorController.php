<?php

namespace App\Http\Controllers\teacher\exam;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionEditorController extends Controller
{
    public function autoSave(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'integer', 'exists:exams,id'],
            'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
            'new_questions' => ['array'],
            'new_questions.*.id' => ['required', 'string'],
            'new_questions.*.question' => ['nullable', 'string'],
            'new_questions.*.question_delta' => ['nullable', 'array'],
            'new_questions.*.is_rich_text' => ['nullable', 'boolean'],
            'new_questions.*.type' => ['required', 'string'],
            'new_questions.*.weight' => ['required', 'integer', 'min:1'],
            'new_questions.*.ref_answer' => ['nullable'],
            'new_questions.*.options' => ['nullable', 'array'],
            'new_questions.*.options.*.label' => ['required_with:new_questions.*.options', 'integer'],
            'new_questions.*.options.*.option' => ['nullable', 'string'],
            'updated_questions' => ['array'],
            'updated_questions.*.id' => ['required', 'integer', 'exists:questions,id'],
            'updated_questions.*.question' => ['nullable', 'string'],
            'updated_questions.*.question_delta' => ['nullable', 'array'],
            'updated_questions.*.is_rich_text' => ['nullable', 'boolean'],
            'updated_questions.*.type' => ['required', 'string'],
            'updated_questions.*.weight' => ['required', 'integer', 'min:1'],
            'updated_questions.*.ref_answer' => ['nullable'],
            'updated_questions.*.options' => ['nullable', 'array'],
            'updated_questions.*.options.*.id' => ['nullable'],
            'updated_questions.*.options.*.label' => ['required_with:updated_questions.*.options', 'integer'],
            'updated_questions.*.options.*.option' => ['nullable', 'string'],
            'deleted_questions' => ['nullable', 'array'],
            'deleted_questions.*' => ['integer']
        ]);

        $createdQuestions = [];
        $updatedQuestionIds = [];

        DB::transaction(function () use ($validated, &$createdQuestions, &$updatedQuestionIds) {
            foreach ($validated['new_questions'] ?? [] as $questionData) {
                $question = Question::create([
                    'exam_id' => $validated['exam_id'],
                    'teacher_id' => $validated['teacher_id'],
                    'question' =>  '',
                    'question_delta' => $questionData['question_delta'] ?? null,
                    'is_rich_text' => true,
                    'type' => $questionData['type'],
                    'weight' => $questionData['weight'],
                    'ref_answer' => $questionData['ref_answer'] ?? '',
                ]);

                $options = [];
                foreach ($questionData['options'] ?? [] as $optionData) {
                    $option = Option::create([
                        'question_id' => $question->id,
                        'label' => $optionData['label'],
                        'option' => $optionData['option'] ?? '',
                    ]);

                    $options[] = $option->toArray();
                }

                $createdQuestions[] = [
                    'temp_id' => $questionData['id'],
                    'question' => array_merge($question->toArray(), [
                        'options' => $options,
                    ]),
                ];
            }

            foreach ($validated['updated_questions'] ?? [] as $questionData) {
                $question = Question::where('id', $questionData['id'])
                    ->where('exam_id', $validated['exam_id'])
                    ->where('teacher_id', $validated['teacher_id'])
                    ->first();

                if (!$question) {
                    continue;
                }

                $question->update([
                    'question' => $questionData['question'] ?? '',
                    'question_delta' => $questionData['question_delta'] ?? null,
                    'is_rich_text' => $questionData['is_rich_text'] ?? false,
                    'type' => $questionData['type'],
                    'weight' => $questionData['weight'],
                    'ref_answer' => $questionData['ref_answer'] ?? '',
                ]);

                foreach ($questionData['options'] ?? [] as $optionData) {
                    if (!empty($optionData['id']) && is_numeric($optionData['id'])) {
                        Option::where('id', $optionData['id'])
                            ->where('question_id', $question->id)
                            ->update([
                                'label' => $optionData['label'],
                                'option' => $optionData['option'] ?? '',
                            ]);
                    }
                }

                $updatedQuestionIds[] = $question->id;
            }

            foreach ($validated['deleted_questions'] as $deletedQuestionId) {
                Question::findOrFail($deletedQuestionId)->delete();
            }
        });


        return response()->json([
            'status' => 'success',
            'created_questions' => $createdQuestions,
            'updated_question_ids' => $updatedQuestionIds,
        ]);
    }
}
