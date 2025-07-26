<?php

namespace App\Livewire\Exam;

use App\Http\Requests\StoreExamRequest;
use App\Models\Exam;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Collection;
use Livewire\Component;

class AddExam extends Component
{

    public $teachings;
    public $courses;

    public string $title = '';
    public string $start_date = '';
    public string $end_date ='';
    public int $duration = 0;




    public function submit(){

        $validated = $this->validate(StoreExamRequest::class);

        Exam::create([

        ]);



        $this->dispatch('examSubmitted');
    }

    public function mount($teachings, $courses){
        $this->teachings = $teachings;
        $this->courses = $courses;
    }
    public function render()
    {

        return view('livewire.exam.add-exam');
    }
}
