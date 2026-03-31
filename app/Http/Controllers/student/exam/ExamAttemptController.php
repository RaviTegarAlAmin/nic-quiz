<?php

namespace App\Http\Controllers\student\exam;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamTaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class ExamAttemptController extends Controller
{
    public function examAttempt(int $examTakerId)
    {


        $examTaker = ExamTaker::with('examAssignment:id,exam_id,duration', 'student:id')
            ->findOrFail($examTakerId);

        if ($examTaker->status == 'finished') {
            return redirect()->route('student.exams.index')->with('error', 'Ujian sudah berakhir');
        }

        $this->authorizeExamTaker($examTaker);

        $examId = $examTaker->examAssignment->exam_id;

        $exam = Cache::remember(
            "exam-attempt:{$examId}:questions",
            now()->addMinutes(30),
            fn() => Exam::with([
                'questions' => fn($query) => $query
                    ->select('id', 'exam_id', 'question', 'question_delta','is_rich_text' ,'type')
                    ->orderBy('id'),
                'questions.options' => fn($query) => $query
                    ->select('id', 'question_id', 'label', 'option')
                    ->orderBy('label'),
            ])->findOrFail($examId)
        );



        $questions = $exam->questions->map(function ($question) {
            return [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'question_delta' => $question->question_delta,
                'is_rich_text' => $question->is_rich_text,
                'options' => $question->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'question_id' => $option->question_id,
                        'label' => $option->label,
                        'option' => $option->option,
                    ];
                })->values()->all(),
            ];
        })->values();

        $answers = $examTaker->answers()
            ->get(['question_id', 'answer', 'marked']);

        return view('exam-attempt.main', [
            'examTaker' => $examTaker,
            'exam' => $exam,
            'questions' => $questions,
            'answers' => $answers,
        ]);
    }

    public function autoSave(Request $request)
    {
        $validated = $request->validate([
            'exam_taker_id' => ['required', 'integer', 'exists:exam_takers,id'],
            'student_id' => ['nullable', 'integer'],
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
                    'question_id' => $answer['question_id'],
                ],
                [
                    'answer' => $answer['answer'],
                    'marked' => $answer['marked'],
                ]
            );
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function submitExam(Request $request)
    {
        $validated = $request->validate([
            'exam_taker_id' => ['required', 'integer', 'exists:exam_takers,id'],
            'student_id' => ['nullable', 'integer'],
            'status' => ['required', 'string'],
        ]);

        $examTaker = ExamTaker::findOrFail($validated['exam_taker_id']);

        $this->authorizeExamTaker($examTaker);

        try {
            $examTaker->update([
                'status' => $validated['status'],
                'finished_at' => now(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Failed to Submit',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
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
