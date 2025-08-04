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
    #[Validate]
    public string $start_at = '';
    #[Validate]
    public string $end_at = '';
    #[Validate]
    public int $duration = 0;

    public bool $examlocked = true;

    public function mount($exam)
    {
        $this->exam = $exam;
        $this->title = $exam->title;
        $this->start_at = $exam->start_at;
        $this->end_at = $exam->end_at;
        $this->duration = $exam->duration;
        $this->courseName = $exam->course->name;
    }

        protected function rules()
    {
        return [
            'title' => 'required|string|min:5|',
            'start_at' => ['required', 'date', 'after:now'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'duration' => 'required|integer|min:30'
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
        $this->reset('start_at');
        $this->reset('end_at');
        $this->reset('duration');
    }

    public function lockExam(){
        $this->resetValidation();
        $this->examlocked = true;
        $this->hydrateFromExam();
    }

public function hydrateFromExam()
{
    $this->title = $this->exam->title;
    $this->start_at = $this->exam->start_at;
    $this->end_at = $this->exam->end_at;
    $this->duration = $this->exam->duration;
    $this->status = $this->exam->status;
}


    public function render()
    {
        return view('livewire.exam.edit-exam');
    }
}
