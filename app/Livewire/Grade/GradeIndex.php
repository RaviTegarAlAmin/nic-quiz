<?php

namespace App\Livewire\Grade;

use App\Models\Exam;
use App\Models\ExamAssignment;
use Illuminate\Support\Collection;
use Livewire\Component;

class GradeIndex extends Component
{
    public $exam;

    public ?string $test = 'test';

    public $examAssignments;

    public  $currentAssignment;

    public function changeCurrentAssignment(int $assignmentId){
        $this->currentAssignment = $this->examAssignments->firstWhere('id',$assignmentId);
        dd($this->currentAssignment);
    }

    public function testingFunction(){
        $this->test = 'berhasil';
    }

    public function mount(Exam $exam)
    {
        $examId = $exam->id;

        $this->examAssignments =
            ExamAssignment::where('exam_id', $examId)
                ->with('examTakers.student.classroom')->get();

        $this->exam = $exam;
    }


    public function render()
    {
        return view('livewire.grade.index');
    }
}
