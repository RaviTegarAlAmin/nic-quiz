<?php

namespace App\Livewire\Admin\Student;

use App\Models\Classroom;
use App\Models\Student;
use Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Excel;

class IndexStudent extends Component
{


    /* Form data */
    public bool $modalform = false;
    public bool $modalDelete = false;
    public bool $modalEdit = false;
    public bool $modalUpload = false;
    public ?int $formStudentId = null;

    public Student $selectedStudent;


    /*  */

    public $classrooms;

    public $currentClassroom;

    public ?int $currentClassroomId = null;

    public $currentStudents;

    public function changeCurrentClassroom(int $classroomId)
    {

        $this->currentClassroom = collect($this->classrooms)
            ->firstWhere('id', $classroomId);

        $this->currentClassroomId = $classroomId;


        $this->currentStudents = Cache::remember(
            "students.classroom_id:{$classroomId}",
            now()->addMinutes(60),
            function () use ($classroomId) {
                return Student::where('classroom_id', $classroomId)->orderBy('name')->get();
            }
        );
    }

    /* Form Handling */


    //Add Student Form
    #[On('close-form')]
    public function closeForm()
    {

        $this->modalform = false;

    }


    //Delete Modal
    public function openDeleteModal($studentId)
    {

        $this->modalDelete = true;
        $this->formStudentId = $studentId;
        $this->selectedStudent = Student::findOrFail($studentId);

    }

    public function closeDeleteModal()
    {

        $this->modalDelete = false;
    }


    //Edit Form
    public function openEditModal($studentId)
    {

        $this->modalEdit = true;
        $this->formStudentId = $studentId;

    }

    #[On('close-edit-modal')]
    public function closeEditModal()
    {
        $this->modalEdit = false;

    }

    public function openUploadModal()
    {
        $this->modalUpload = true;
    }

    #[On('close-upload-modal')]
    public function closeUploadModal()
    {
        $this->modalUpload = false;
    }

    /*  ****************************** */


    /* CRUD Handling */

    public function deleteStudent()
    {

        try {
            $this->selectedStudent->delete();

            $this->reset('formStudentId');

            $this->dispatch('refresh-table');

            $this->closeDeleteModal();

            $this->dispatch('show-toast', [
                'message' => 'Siswa Berhasil Dihapus',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {

            $this->reset('formStudentId');

            $this->closeDeleteModal();

            $this->dispatch('show-toast', [
                'message' => 'Siswa Gagal Dihapus',
                'type' => 'failed'
            ]);
        }



    }


    public function mount()
    {
        $this->classrooms = Classroom::withCount([
            'students as male_student' => fn($q) => $q->where('gender', 'Laki-Laki'),
            'students as female_student' => fn($q) => $q->where('gender', 'Perempuan'),
            'students as total_student',
        ])->get()->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'grade' => $c->grade,
                'male_student' => $c->male_student,
                'female_student' => $c->female_student,
                'total_student' => $c->total_student,
            ])->toArray();
    }


    #[On('refresh-table')]
    public function render()
    {

        return view('livewire.admin.student.index-student');
    }
}
