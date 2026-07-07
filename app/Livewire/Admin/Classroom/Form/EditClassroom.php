<?php

namespace App\Livewire\Admin\Classroom\Form;

use App\Services\Classroom\ClassroomActionService;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditClassroom extends Component
{
    public array $classroomData;

    public int $classroomId;

    #[Validate('required|string|max:50')]
    public ?string $name = null;

    #[Validate('required|integer|min:1|in:7,8,9')]
    public ?int $grade = null;

    #[Validate('required|integer|min:1')]
    public ?int $capacity = null;

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama kelas wajib diisi.',
            'name.string' => 'Nama kelas harus berupa teks.',
            'name.max' => 'Nama kelas maksimal 50 karakter.',
            'grade.required' => 'Tingkat kelas wajib dipilih.',
            'grade.integer' => 'Tingkat kelas harus berupa angka.',
            'grade.min' => 'Tingkat kelas minimal 1.',
            'grade.in' => 'Tingkat tidak sesuai',
            'capacity.required' => 'Kapasitas wajib diisi.',
            'capacity.integer' => 'Kapasitas harus berupa angka.',
            'capacity.min' => 'Kapasitas minimal 1.',
        ];
    }

    public function mount()
    {
        $this->classroomId = $this->classroomData['id'];
        $this->grade = $this->classroomData['grade'];
        $this->capacity = $this->classroomData['capacity'];
        $this->name = $this->classroomData['name'];

    }

    public function save(ClassroomActionService $cas)
    {

        $this->validate();

        $cas->updateClassroom(
            $this->classroomId,
            $this->name,
            $this->grade,
            $this->capacity
        );

        $this->dispatch('classroom-edited', classroom: [
            'id' => $this->classroomId,
            'name' => $this->name,
            'grade' => $this->grade,
            'capacity' => $this->capacity,
        ]);

        $this->dispatch('close-edit');

    }



    public function render()
    {
        return view('livewire.admin.classroom.form.edit-classroom');
    }
}
