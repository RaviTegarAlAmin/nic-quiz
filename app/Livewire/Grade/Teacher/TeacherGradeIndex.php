<?php

namespace App\Livewire\Grade\Teacher;

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Services\Grade\CorrectionService;
use Livewire\Attributes\On;
use Livewire\Component;

class TeacherGradeIndex extends Component
{
    public $exam;

    public $examAssignments = null ;

    public $currentAssignment;


    public function correction(ExamAssignment $currentAssignment,  CorrectionService $corectionService){
        $corectionService->correction($this->currentAssignment);

        $this->dispatch('data-changed')->self();
    }


    public function changeCurrentAssignment(int $assignmentId)
    {
        $this->currentAssignment = $this->examAssignments->firstWhere('id', $assignmentId);
    }

    public function mount(Exam $exam)
    {

        $examId = $exam->id;

        $this->examAssignments =
            ExamAssignment::where('exam_id', $examId)
                ->with('examTakers.student.classroom', 'examTakers.grade')
                ->get();

        $this->exam = $exam->load('questions');


        $this->currentAssignment = null;
    }

    #[On('data-changed')]
    public function render()
    {
        return view('livewire.grade.teacher.teacher-grade-index');
    }
}
