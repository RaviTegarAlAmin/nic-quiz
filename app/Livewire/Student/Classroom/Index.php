<?php

namespace App\Livewire\Student\Classroom;


use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teaching;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Index extends Component
{
    public $teachings;

    public $students;

    public $classroom;

    #[Layout('layout.main')]

    public function mount()
    {
        $classroomId = auth()->user()->entity()->classroom_id;

        $teachings =
            $teachings = Teaching::where('classroom_id', $classroomId)
                ->with(['teacher:id,gender,name', 'course:id,name,code', 'schedules'])
                ->join('teachers', 'teachers.id', '=', 'teachings.teacher_id')
                ->orderBy('teachers.name')
                ->select('teachings.*')
                ->get();

        $students = Student::where('classroom_id', $classroomId)->orderBy('name')->get(['id','name','nis', 'gender']);

        $classroom = Classroom::where('id',$classroomId)->with('homeroomTeacher')->first();

        $this->teachings = $teachings->toArray();
        $this->students = $students->toArray();
        $this->classroom = $classroom->toArray();

        //Caching later

        /*         $this->classroomData =
                    Cache::rememberForever(
                        'classroom:' . $classroomId,
                        function () use ($classroomId) {

                            $teachings =
                                $teachings = Teaching::where('classroom_id', $classroomId)
                                    ->with(['teacher:id,gender,name', 'course:id,name,code', 'schedules'])
                                    ->join('teachers', 'teachers.id', '=', 'teachings.teacher_id')
                                    ->orderBy('teachers.name')
                                    ->select('teachings.*')
                                    ->get()
                                    ->toArray();

                            $students = Student::where('classroom_id', $classroomId)->orderBy('name')->get();

                            $classroom = Classroom::findOrFail($classroomId);

                            $data['teachings'] = $teachings;
                            $data['students'] = $students;
                            $data['classroom'] = $classroom;

                            return $data;
                        }
                    ); */

    }

    public function placeholder(){

        return view('livewire.student.classroom.index-placeholder');
    }
    public function render()
    {

        return view('livewire.student.classroom.index');
    }
}
