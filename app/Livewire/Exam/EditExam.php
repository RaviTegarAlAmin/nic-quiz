<?php

namespace App\Livewire\Exam;

use App\Models\Exam;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditExam extends Component
{
    public $exam;

    public string $courseName;

    #[Validate]
    public string $title = '';


    public bool $examlocked = true;

    public function mount($exam)
    {
        $this->exam = $exam;
        $this->title = $exam->title;
        $this->courseName = $exam->course->name;
    }

        protected function rules()
    {
        return [
            'title' => 'required|string|min:5|'
        ];
    }

    public function updateExam(){

        $validated =  $this->validate();

        $this->exam->update($validated);

        $this->examlocked = true;
    }

    public function unlockExam(){
        $this->examlocked = false;
    }

    public function deleteExam(){
        $this->exam->delete();

        return redirect()->route('dashboard.teacher');
    }

    public function resetData(){
        $this->reset('title');

    }

    public function lockExam(){
        $this->resetValidation();
        $this->examlocked = true;
        $this->hydrateFromExam();
    }

public function hydrateFromExam()
{
    $this->title = $this->exam->title;
}

    public function render()
    {
        return view('livewire.exam.edit-exam');
    }
}
