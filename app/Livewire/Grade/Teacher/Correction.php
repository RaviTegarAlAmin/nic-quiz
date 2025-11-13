<?php

namespace App\Livewire\Grade\Teacher;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamTaker;

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Correction extends Component
{
    use WithPagination;

    public $exam;
    public Collection $examTakers;
    public $currentExamTaker;
    public ?int $currentExamTakerId = null;
    public ?int $examTakerId = null;

    // Minimize state keyed by question DB id
    public array $minimize = [];

    // Pagination
    public int $perPage = 10;

    public function mount(Exam $exam, Collection $examTakers, ?int $examTakerId)
    {
        $this->exam = $exam;
        $this->examTakers = $examTakers;
        $this->examTakerId = $examTakerId;

        $firstExamTakerId = $examTakers->pluck('id')->first();

        if ($examTakerId) {
            $this->currentExamTakerId = $examTakerId;
            $this->currentExamTaker = $this->examTakers->where('id', $examTakerId)->first();
        } else {
            $this->currentExamTakerId = $firstExamTakerId;
            $this->currentExamTaker = $this->examTakers->where('id', $firstExamTakerId)->first();
        }

        // Initialize minimize state for all questions
        foreach ($this->exam->questions as $question) {
            $this->minimize[$question->id] = $this->minimize[$question->id] ?? false;
        }
    }

    /**
     * Change items per page
     * @param int|string $value
     */
    public function changePerPage($value)
    {
        $this->perPage = (int) $value;
        $this->resetPage();
    }

    /**
     * Updated hook for currentExamTakerId
     */
    public function updatedCurrentExamTakerId($value)
    {
        $this->currentExamTaker = $this->examTakers->where('id', $value)->first();
        $this->resetPage();
    }

    /**
     * Navigate to previous exam taker
     */
    public function previousExamTaker()
    {
        $currentIndex = $this->examTakers->search(function ($examTaker) {
            return $examTaker->id === $this->currentExamTakerId;
        });

        if ($currentIndex > 0) {
            $previousExamTaker = $this->examTakers[$currentIndex - 1];
            $this->currentExamTakerId = $previousExamTaker->id;
            $this->currentExamTaker = $previousExamTaker;
            $this->resetPage();
        }
    }

    /**
     * Navigate to next exam taker
     */
    public function nextExamTaker()
    {
        $currentIndex = $this->examTakers->search(function ($examTaker) {
            return $examTaker->id === $this->currentExamTakerId;
        });

        if ($currentIndex < $this->examTakers->count() - 1) {
            $nextExamTaker = $this->examTakers[$currentIndex + 1];
            $this->currentExamTakerId = $nextExamTaker->id;
            $this->currentExamTaker = $nextExamTaker;
            $this->resetPage();
        }
    }

    public function render()
    {
        // Get paginated questions
        $questions = $this->exam->questions()
            ->paginate($this->perPage);

        // Get all answers for current exam taker (only once per render)
        $currentAnswers = Answer::where('exam_taker_id', $this->currentExamTakerId)
            ->with('embedding')
            ->get()
            ->keyBy('question_id');

        // Map answers to paginated questions
        $questionAnswers = $questions->through(function ($question) use ($currentAnswers) {
            return [
                'question' => $question,
                'answer' => $currentAnswers->get($question->id)
            ];
        });

        return view('livewire.grade.teacher.correction', [
            'questionAnswers' => $questionAnswers,
            'questions' => $questions
        ]);
    }
}
