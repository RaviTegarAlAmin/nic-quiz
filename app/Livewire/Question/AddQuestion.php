<?php

namespace App\Livewire\Question;

use App\Models\Exam;
use App\Models\Question;
use Livewire\Component;

class AddQuestion extends Component
{
    public $exam;
    public $teacher;

    public array $questions = [];
    public array $options = [];

    public string $question = '';
    public int $weight = 1;
    public string $type = 'multiple_choice';

    public array $typeList = ['Pilihan Ganda' => 'multiple_choice', 'Esai' => 'essay'];

    public string $ref_answer = '';

/*     protected function rules(){
        return [

        ];
    } */
    public function addQuestion(){
        Question::create([
            'exam_id' => $this->exam->id,
            'teacher_id' => $this->teacher->id,

            'question' => 'default',
            'type' => $this->type,
            'weight' => $this->weight,
            'ref_answer' => 'default',
        ]);

        $this->exam->refresh();
        $this->questions = $this->exam->questions->toArray();
    }

    public function updatedQuestions($value, $key){
        [$index, $field] = explode('.', $key);

        $questionId = $this->questions[$index]['id'];

        if ($questionId && in_array($field, ['weight', 'ref_answer','type','question'])) {
            Question::where('id',$questionId)->update([
                $field => $value
            ]);
        }
    }


    public function mount( Exam $exam){
        $this->exam = $exam->load('questions');
        $this->questions = $this->exam->questions->toArray();
        $this->teacher = auth()->user()->load('teacher')->teacher;
    }
    public function render()
    {
        return view('livewire.question.add-question');
    }
}
