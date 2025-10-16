<?php

namespace App\Livewire\Student;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\ExamTaker;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use function PHPUnit\Framework\isNull;

#[Layout('components.layouts.app')]
class ExamAttempt extends Component
{
    public $examTakerData;

    //ExamData
    public array $exam = [];
    public int $examTakerId;

    public $examAssignment;

    //QuestionData

    public int $currentIndex = 0;

    public array $question = [];

    public int $totalQuestions = 0;

    public int $answeredQuestions = 0;

    //AnswerData

    public ?string $currentAnswer = null;

    public ?array $answer = null;

    public bool $marked = false;

    public ?array $markedQuestions = [];

    //Answer Card

    /* This for multiple choice type of question */
    public function toggleCorrectAnswer(string $label)
    {
        if ($this->currentAnswer == $label) {
            $label = null;
        }

        $this->currentAnswer = $label;
    }

    public function toggleMarkedAnswer()
    {
        $this->marked = !$this->marked;
    }

    /* Saving Current Answer */

    public function saveCurrentAnswer()
    {

        try {
            $previousAnswer = $this->answer[$this->question['id']] ?? null;

            Answer::updateOrCreate(
                [
                    'exam_taker_id' => $this->examTakerId,
                    'question_id' => $this->question['id']
                ],
                [
                    'answer' => $this->currentAnswer,
                    'marked' => $this->marked
                ]
            );

            if (!empty($previousAnswer) && (is_null($this->currentAnswer) || $this->currentAnswer == '')) {
                $this->answeredQuestions -= 1;
            } elseif (empty($previousAnswer) && (!is_null($this->currentAnswer) && $this->currentAnswer != '')) {
                $this->answeredQuestions += 1;
            }

            $this->answer[$this->question['id']] = $this->currentAnswer;
            $this->markedQuestions[$this->question['id']] = $this->marked;



            $this->reset('currentAnswer');
            $this->reset('marked');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Update Jawaban!');
        }

    }



    //Navigation
    public function changeIndex(int $index)
    {
        $this->saveCurrentAnswer();

        if ($index >= 0 && $index < count($this->exam['questions'])) {
            $this->currentIndex = $index;
        }

        $this->currentAnswer = $this->answer[$this->exam['questions'][$index]['id']] ?? null;
        $this->marked = $this->markedQuestions[$this->exam['questions'][$index]['id']] ?? false;

    }

    public function mount(int $examTakerId)
    {

        //initialize exam taker data
        $this->examTakerId = $examTakerId;

        $this->examTakerData = ExamTaker::with('student')->findOrFail($examTakerId);

        //authoriziation

/*         if ($this->authorize('attempt', $this->examTakerData)) {
            abort(403);
        }

        if ($this->authorize('finished', $this->examTakerData)) {
            abort(403);
        } */

        $examAssignment = ExamAssignment::query()
            ->whereHas('examTakers', function ($q) use ($examTakerId) {
                $q->where('id', $examTakerId);
            })
            ->with([
                'exam.questions.options',
                'teaching.teacher',
                'teaching.course',
                'teaching.classroom',
            ])
            ->firstOrFail();


        $exam = $examAssignment->exam;

        $this->examAssignment = $examAssignment->toArray();

        $this->exam = $exam->toArray();

        $this->totalQuestions = count($exam['questions']);

        //initialize answer data

        $answer = Answer::where('exam_taker_id', $this->examTakerId)->get();

        $this->answer = $answer->pluck('answer', 'question_id')->toArray();
        $this->markedQuestions = $answer->pluck('marked', 'question_id')->toArray();

        $this->currentAnswer = $this->answer[$exam['questions'][$this->currentIndex]['id']] ?? null;
        $this->marked = $this->markedQuestions[$exam['questions'][$this->currentIndex]['id']] ?? false;

        $this->answeredQuestions = 0;
        foreach ($this->answer as $ans) {
            if (!is_null($ans) && $ans !== '') {
                $this->answeredQuestions++;
            }
        }


    }

    //Submit Exam

    public function submit()
    {

        try {
            $this->saveCurrentAnswer();

            $this->examTakerData->update([
                'finished_at' => now()
            ]);

            return redirect()->route('student.exams.index')->with('success', "Berhasil menyelesaikan ujian");

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal Submit Ujian');
        }

    }


    public function render()
    {

        $this->question = $this->exam['questions'][$this->currentIndex];

        return view('livewire.student.exam-attempt', [
            'currentIndex' => $this->currentIndex,
            'examTakerId' => $this->examTakerId,
            'question' => $this->question,
            'answer' => $this->currentAnswer
        ]);
    }
}
