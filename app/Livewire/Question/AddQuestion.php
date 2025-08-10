<?php

namespace App\Livewire\Question;

use App\Models\Exam;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddQuestion extends Component
{
    public Exam $exam;
    public $teacher;

    public array $questions = [];
    public array $options = [];

    public array $label = ['A', 'B', 'C', 'D'];

    public string $question = '';

    public int $weight = 1;
    public string $type = 'multiple_choice';

    public array $typeList = ['Pilihan Ganda' => 'multiple_choice', 'Esai' => 'essay'];

    public string $ref_answer = '';

    // minimize state keyed by question DB id
    public array $minimize = [];

    public function mount(Exam $exam)
    {
        $this->exam = $exam->load('questions.options');
        $this->teacher = auth()->user()->load('teacher')->teacher;

        $this->questions = $this->exam->questions->map(function ($q) {
            $arr = $q->toArray();
            // ensure minimize entry exists for this question id
            $this->minimize[$q->id] = $this->minimize[$q->id] ?? false;
            return $arr;
        })->toArray();

        $this->options = $this->exam->questions->mapWithKeys(function ($q) {
            return [$q->id => $q->options->toArray()];
        })->toArray();


    }

    public function addQuestion()
    {
        DB::transaction(function () {

            $q = Question::create([
                'exam_id' => $this->exam->id,
                'teacher_id' => $this->teacher->id,
                'type' => $this->type,
                'weight' => $this->weight,
                'question' => $this->question,
                'ref_answer' => $this->ref_answer,
            ]);

            $options = [];
            for ($i = 0; $i < 4; $i++) {
                $options[] = Option::create([
                    'question_id' => $q->id,
                    'label' => $i + 1,
                ])->toArray();

                // Store all 4 options for this question
                $this->options[$q->id] = $options;
            }

            // ensure collapse state for new question
            $this->minimize[$q->id] = false;
        });

        $this->refreshQuestions();
    }

    /**
     * Handle nested updates like questions.0.question
     * $key example: "questions.2.question" or "questions.2.weight"
     */
    public function updatedQuestions($value, $name)
    {
        // $name comes in the format "index.field"
        [$index, $field] = explode('.', $name);

        // Ensure the index exists and has a valid ID
        if (!isset($this->questions[$index]['id'])) {
            return;
        }

        $questionId = $this->questions[$index]['id'];

        // Commit the change directly to the database
        Question::where('id', $questionId)->update([
            $field => $value
        ]);

        if ($field === 'type') {
            if ($value === 'essay') {
                Option::where('question_id', $questionId)->delete();
                unset($this->options[$questionId]);
            } elseif ($value === 'multiple_choice') {

                $options = [];
                for ($i = 1; $i <= 4; $i++) {

                    $options[] = Option::create([
                        'question_id' => $questionId,
                        'label' => $i,
                    ])->toArray();

                    // Store all 4 options for this question
                    $this->options[$questionId] = $options;
                }
            }

        }

        // Update the local Livewire array so the UI stays in sync
        $this->questions[$index][$field] = $value;
    }





    /**
     * Delete by question id (recommended)
     */
    public function deleteQuestion($questionId)
    {
        // allow accidental index passed: normalize to id
        if (!is_numeric($questionId) && isset($this->questions[$questionId]['id'])) {
            $questionId = $this->questions[$questionId]['id'];
        }

        if (empty($questionId)) {
            return;
        }

        Question::where('id', $questionId)->delete();

        // remove minimize state for this question
        unset($this->minimize[$questionId]);

        // refresh so $questions is consistent with DB
        $this->refreshQuestions();
    }

    public function updatedOptions($value, $name)
    {
        // $name example: "13.0.option"
        // Explode to get questionId, optionIndex, and fieldName
        [$questionId, $optionIndex, $field] = explode('.', $name);

        if ($field === 'option') {
            // Get option data from current property
            $optionData = $this->options[$questionId][$optionIndex];

            // Update the option in DB by id
            Option::where('id', $optionData['id'])
                ->update(['option' => $value]);
        }
    }


    public function refreshQuestions()
    {
        $oldMinimize = $this->minimize;

        $this->exam->refresh();

        $this->questions = Question::where('exam_id', $this->exam->id)
            ->orderBy('id')
            ->get()
            ->map(function ($q) use ($oldMinimize) {
                $arr = $q->toArray();

                // merge preserve minimize state keyed by DB id
                $this->minimize[$q->id] = $oldMinimize[$q->id] ?? ($this->minimize[$q->id] ?? false);

                return $arr;
            })
            ->toArray();
    }

    public function toggleMinimize($questionId)
    {
        // normalize if an index was passed
        if (!is_numeric($questionId) && isset($this->questions[$questionId]['id'])) {
            $questionId = $this->questions[$questionId]['id'];
        }

        $this->minimize[$questionId] = !($this->minimize[$questionId] ?? false);
    }

    public function toggleCorrectAnswer( $questionId, $value){
        Question::where('id',$questionId)->update([
            'ref_answer' => $value
        ]);

        $this->refreshQuestions();
    }


    public function render()
    {
        return view('livewire.question.add-question');
    }
}
