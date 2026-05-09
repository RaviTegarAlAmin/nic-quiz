<?php

namespace App\Livewire\Student\Grade;

use App\Models\ExamTaker;
use App\Models\Student;
use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layout.main')]
class Index extends Component
{
    public Student $student;
    public $examAttempts;
    public $examsData;

    public $currentExamsData;


    //Utility
    public $order = 'desc';
    public string $query = '';
    public string $searchDescription = '';
    public string $sortCategory = 'finished_at';



    //Utility Function
    public function search()
    {

        if ($this->query === '') {
            $this->currentExamsData = $this->examsData;
            $this->searchDescription = '';
            return;
        } else {
            $this->searchByExamName();
        }

        $totalData = count($this->currentExamsData);

        $this->searchDescription = "Menampilkan {$totalData} Data Dari Pencarian \"{$this->query}\"";

    }

    public function sortBy()
    {
        $sortMethod = $this->order === 'asc' ? 'sortKeys' : 'sortKeysDesc';

        if ($this->sortCategory == '') {
            return;
        }

        if ($this->sortCategory === 'course') {

            $mapped = collect($this->currentExamsData)->groupBy('course')->$sortMethod()->values()->toArray();

            $this->currentExamsData = array_merge(...array_values($mapped));

        }

        if ($this->sortCategory === 'finished_at') {

            $mapped = collect($this->currentExamsData)->groupBy('finished_at')->$sortMethod()->values()->toArray();

            $this->currentExamsData = array_merge(...array_values($mapped));

        }

        if ($this->sortCategory === 'name') {

            $mapped = collect($this->currentExamsData)->groupBy('name')->$sortMethod()->values()->toArray();
            $this->currentExamsData = array_merge(...array_values($mapped));
        }

        if ($this->sortCategory === 'score') {

            $sortScore = $this->order == 'asc' ? "sortBy" : "sortByDesc";

            $mapped = collect($this->currentExamsData)->$sortScore('score')->values()->toArray();

            $this->currentExamsData = $mapped;

        }


    }

    public function toggleOrder()
    {
        if ($this->order === 'asc') {
            $this->order = 'desc';
        } else {
            $this->order = 'asc';
        }
    }

    public function mount()
    {

        $this->student = auth()->user()->entity();

        $this->examAttempts = ExamTaker::where('student_id', $this->student->id)
            ->whereHas('grade')
            ->with(['examAssignment.exam.course', 'grade'])
            ->orderByDesc('finished_at')
            ->get();

        $this->examsData = $this->mapExamsData($this->examAttempts);

        $this->currentExamsData = $this->examsData;

    }


    //Mapping ExamsData

    protected function mapExamsData($examAttempts): mixed
    {


        return $examAttempts->map(function ($attempt) {

            return [
                'id' => $attempt->examAssignment->exam->id,
                'name' => $attempt->examAssignment->exam->title,
                'finished_at' => $attempt->finished_at,
                'course' => $attempt->examAssignment->exam->course->name,
                'score' => $attempt->grade->exam_score
            ];
        })->toArray();

    }

    //Search Query

    protected function searchByExamName()
    {
        $this->currentExamsData =
            array_filter($this->examsData, function ($exam) {
                return stripos($exam['name'], $this->query) !== false;
            });

        $this->sortBy();
    }


    public function render()
    {
        return view('livewire.student.grade.index');
    }
}
