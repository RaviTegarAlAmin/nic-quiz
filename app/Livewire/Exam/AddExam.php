<?php

namespace App\Livewire\Exam;


use App\Models\Exam;
use Livewire\Attributes\Validate;
use Livewire\Component;
use function Livewire\after;

class AddExam extends Component
{
    // Eloquent Data

    public $courses;
    public $newExam;

    //Properties

    public $courseId = '';

    #[Validate]
    public string $title = '';
    public string $start_at = '';
    #[Validate]
    public string $end_at = '';
    #[Validate]
    public int $duration = 0;


    protected function rules()
    {
        return [
            'title' => 'required|string|min:5|unique:exams,title',
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'duration' => 'required|integer|min:30'
        ];
    }

    public function addExam()
    {
        $validated = $this->validate();

        $this->newExam = Exam::create([
            'course_id' => $this->courseId,
            ...$validated,
            'status' => 'not_started'
        ]);

        return redirect()->route('exams.edit', ['exam' => $this->newExam])
                ->with('success', 'Ujian berhasil dibuat!');
    }




    public function mount( $courses)
    {
        $this->courses = $courses;
    }
    public function render()
    {

        return view('livewire.exam.add-exam');
    }
}
