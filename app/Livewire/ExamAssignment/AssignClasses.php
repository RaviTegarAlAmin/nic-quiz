<?php

namespace App\Livewire\ExamAssignment;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\Teaching;
use Date;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AssignClasses extends Component
{

    public $exam;
    public $teachings;

    #[Validate]
    public $duration = null;

    #[Validate]
    public string $start_at = '';

    #[Validate]
    public string $end_at = '';

    public array $assignedTeaching = [];

    public function rules()
    {
        return [
            'duration' => 'required|integer|min:30',
            'start_at' => 'required|date|after:now',
            'end_at' => 'required|date|after:start_at'
        ];
    }


    public function toggleAssignedTeaching($teaching)
    {
        if (in_array($teaching, $this->assignedTeaching)) {
            $this->assignedTeaching = array_diff($this->assignedTeaching, [$teaching]);
        } else {
            $this->assignedTeaching[] = $teaching;
        }

    }


    public function assignExam()
    {
        $validated = $this->validate();

        foreach ($this->assignedTeaching as $teachingId) {

            ExamAssignment::create([
                'teaching_id' => $teachingId,
                'exam_id' => $this->exam->id,
                'status' => 'not_started',
                ...$validated
            ]);
        }

        $this->refreshAssignment();

        $this->dispatch('show-toast', [
            'message' => 'Penugasan Berhasil Ditambahkan',
            'type' => 'success'
        ]);

        $this->dispatch('refresh-table');

    }

    public function refreshAssignment()
    {
        $this->reset('duration');
        $this->reset('start_at');
        $this->reset('end_at');
        $this->reset('assignedTeaching');
    }


    public function mount(Exam $exam)
    {
        $this->exam = $exam;
        $this->teachings = Teaching::with('classroom')->where([
            ['course_id', '=', $exam->course_id],
            ['teacher_id', '=', $exam->teacher_id],
        ])->get();


    }

    public function render()
    {
        return view('livewire.exam-assignment.assign-classes');
    }
}
