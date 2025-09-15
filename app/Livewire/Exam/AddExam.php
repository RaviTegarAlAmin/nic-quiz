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
    #[Validate]
    public $courseId = '';

    #[Validate]
    public string $title = '';



    protected function rules()
    {
        return [
            'title' => 'required|string|min:5|unique:exams,title',
            'courseId' => 'required'
        ];
    }

    protected function messages()
    {
        return [
            'title.required' => 'Judul ujian wajib diisi.',
            'title.min' => 'Judul ujian minimal harus terdiri dari 5 karakter.',
            'title.unique' => 'Judul ujian sudah digunakan, silakan pilih judul lain.',
            'courseId.required' => 'Mata pelajaran wajib dipilih.',
        ];
    }

    public function addExam()
    {
        $validated = $this->validate();

        $this->newExam = Exam::create([
            'teacher_id' => auth()->user()->teacher->id,
            'course_id' => $validated['courseId'],
            'title' => $validated['title']
        ]);

        return redirect()->route('exams.edit', ['exam' => $this->newExam])
            ->with('success', 'Ujian berhasil dibuat!');
    }




    public function mount($courses)
    {
        $this->courses = $courses;
    }
    public function render()
    {

        return view('livewire.exam.add-exam');
    }
}
