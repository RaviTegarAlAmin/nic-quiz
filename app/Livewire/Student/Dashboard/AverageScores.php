<?php

namespace App\Livewire\Student\Dashboard;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AverageScores extends Component
{

    /*
        $averageScores = [
                'name' => course name
                'code' => course code
                'average' => average score per course
                'graded_exams' => graded exams per course useful to count ungraded
        ]

    */
    public $averageScores = [];

    public int $finishedExams = 0;

    public float $averageTotal;
    public int $gradedExams = 0;
    public int $maxIndex = 0;
    public int $minIndex = 0;


    public function mount()
    {

        $this->calculateAverageTotal();

    }


    /*
         - Average From All Course
         - Graded Course counts to calculate the average
         - Graded Exams counts to count ungraded exams
         - Max and Min Averages
    */
    protected function calculateAverageTotal()
    {

        //Guard
        if (count($this->averageScores) < 1) {
            return;
        }

        //Main Init
        $sum = 0;
        $gradedCourses = 0;

        //Getting necessary data through one loop
        foreach ($this->averageScores as $index => $score) {
            $sum += $score['average'];
            $this->gradedExams += $score['graded_exams'];

            //Max, Min, GradedCourses count
            if (!is_null($score['average'])) {
                $gradedCourses += 1;

                if ($score['average'] < $this->averageScores[$this->minIndex]['average']) {
                    $this->minIndex = $index;
                }

                if ($score['average'] > $this->averageScores[$this->maxIndex]['average']) {
                    $this->maxIndex = $index;
                }

            }
        }

        $this->averageTotal = round($sum / $gradedCourses, 2);


    }


    public function render()
    {
        return view('livewire.student.dashboard.average-scores');
    }
}
