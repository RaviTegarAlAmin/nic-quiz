<?php

namespace App\Livewire;

use App\Models\ExamAssignment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;


/* This Data Tabe specficicay created for Exam Asssignment */
class DataTable extends Component
{
    public $model;

    public int $modelId = 0;

    public array $columns = [];

    public string $status = '';

    public function mount($modelId)
    {
        $this->modelId = $modelId;
    }

    public function delete(ExamAssignment $assignment)
    {

        $assignment->delete();

        $this->dispatch('show-toast', [
            'message' => 'Penugasan Dihapus',
            'type' => 'warning'
        ]);

        $this->dispatch('refresh-table');
    }

    public function publishExam(ExamAssignment $assignment)
    {

        $published = !$assignment->published;
        $assignment->update(['published' => $published]);


        if ($published === true) {
            $this->dispatch('show-toast', [
                'message' => 'Berhasil Menyebarkan Ujian',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('show-toast', [
                'message' => 'Ujian Ditarik',
                'type' => 'warning'
            ]);
        }

        $this->dispatch('refresh-table');

    }

    public function changeStatus(int $assignmentId, $status)
    {
        ExamAssignment::findOrFail($assignmentId)->update(['status' => $status]);
        $this->dispatch('refresh-table');
        if ($status == 'ongoing') {
            $this->dispatch('show-toast',['message' => 'Ujian Berhasil Dimulai', 'type' => 'success']);
        } elseif ($status == 'on_hold') {
            $this->dispatch('show-toast', ['message' => 'Ujian Ditunda', 'type' => 'warning']);
        } elseif ($status == 'finished') {
            $this->dispatch('show-toast' , ['message' => 'Ujian Dihentikan', 'type' => 'failed']);
        }
    }

    #[On('refresh-table')]
    public function render()
    {
        $this->model = ExamAssignment::with('exam', 'teaching.classroom')->where('exam_id', $this->modelId)->latest()->get();
        return view('livewire.data-table', ['model' => $this->model, 'action' => true]);
    }

}
