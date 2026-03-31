<?php

namespace App\Http\Controllers\api\student\exam;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\ExamTaker;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ExamAttemptController extends Controller
{
    public function autoSave(Request $request)
    {
        $validated = $request->validate([
            'exam_taker_id' => ['required', 'integer', 'exists:exam_takers,id'],
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.question_id' => ['required', 'integer', 'exists:questions,id'],
            'answers.*.answer' => ['nullable', 'string'],
            'answers.*.marked' => ['required', 'boolean'],
        ]);

        $examTaker = ExamTaker::with('examAssignment.exam.questions:id,exam_id')
            ->findOrFail($validated['exam_taker_id']);

        $this->authorizeExamTaker($examTaker);
        $this->ensureQuestionsBelongToExam(
            collect($validated['answers'])->pluck('question_id')->all(),
            $examTaker
        );

        foreach ($validated['answers'] as $answer) {
            Answer::updateOrCreate(
                [
                    'exam_taker_id' => $validated['exam_taker_id'],
                    'question_id' => $answer['question_id']
                ],
                [
                    'answer' => $answer['answer'],
                    'marked' => $answer['marked']
                ]
            );
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function submitExam(Request $request)
    {

        $validated = $request->validate([
            'exam_taker_id' => ['required', 'integer', 'exists:exam_takers,id'],
            'student_id' => ['nullable','integer'],
            'status' => ['required', 'string']
        ]);

        $examTaker = ExamTaker::findOrFail($validated['exam_taker_id']);

        $this->authorizeExamTaker($examTaker);

        try {
            $examTaker->update([
                'status' => $validated['status'],
                'finished_at' => now()
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Failed to Submit'
            ], 403);
        }

        return response()->json([
            'status' => 'success'
        ], 200);

    }

    private function authorizeExamTaker(ExamTaker $examTaker): void
    {
        $studentId = auth()->user()?->student?->id;

        abort_unless($studentId && $examTaker->isAuthorized($studentId), 403);
    }

    private function ensureQuestionsBelongToExam(array $questionIds, ExamTaker $examTaker): void
    {
        $allowedQuestionIds = $examTaker->examAssignment->exam->questions
            ->pluck('id')
            ->all();

        $invalidQuestionIds = collect($questionIds)
            ->unique()
            ->diff($allowedQuestionIds);

        if ($invalidQuestionIds->isNotEmpty()) {
            throw ValidationException::withMessages([
                'answers' => 'One or more submitted questions do not belong to this exam.',
            ]);
        }
    }
}
