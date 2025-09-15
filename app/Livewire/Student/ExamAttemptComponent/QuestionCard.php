<?php

namespace App\Livewire\Student\ExamAttemptComponent;

use App\Models\Answer;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

class QuestionCard extends Component
{
    public ?array $question = [];
    public ?int $number = 0;

    public ?int $examTakerId;

    //Answer Variables

    public ?string $currentAnswer = null;





    public function updatedCurrentAnswer($value)
    {
        $this->currentAnswer = $value;
    }

    #[On('navigate')]
    public function saveCurrentAnswer(int $index)
    {

        if ($this->currentAnswer != null) {
            try {

                $answer = Answer::updateOrCreate(
                    [
                        'exam_taker_id' => $this->examTakerId,
                        'question_id' => $this->question['id']
                    ],
                    [
                        'answer' => $this->currentAnswer
                    ]
                );



            } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Gagal Update Jawaban!');
            }
        }

        $this->dispatch('answer-saved', index: $index, answer: $this->currentAnswer);
    }


    public function mount(array $question, ?string $currentAnswer = null)
    {
        $this->question = $question;
        $this->currentAnswer = $currentAnswer;
    }

    #[Lazy(isolate: false)]
    public function render()
    {
        return view('livewire.student.exam-attempt-component.question-card', ['question' => $this->question]);
    }
}
