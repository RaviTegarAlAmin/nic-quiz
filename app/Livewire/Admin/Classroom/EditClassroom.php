<?php

namespace App\Livewire\Admin\Classroom;

use App\Models\Classroom;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditClassroom extends Component
{
    public $classroom = null;

    //Properties
    #[Validate]
    public int $capacity;

    #[Validate]
    public string $name;

    #[Validate]
    public string $grade;

    protected function rules()
    {
        return [
            'name' => 'required|unique:classrooms,name|string',
            'grade' => 'required|string',
            'capacity' => 'required|integer|min:1|max:36'
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Isi nama kelas',
            'name.min' => 'Karakter nama kelas kurang',
            'name.max' => 'Nama kelas terlalu panjang',
            'name.unique' => 'Nama kelas sudah ada',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.min' => 'Kapasitas tidak sesuai',
            'capacity.max' => 'Kapasitas tidak sesuai'
        ];
    }

    public function editClassroom()
    {
        $validated = $this->validate();

        $this->classroom->update([
            'grade' => $validated['grade'],
            'name' => $validated['name'],
            'capacity' => $validated['capacity']
        ]);

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Kelas berhasil diubah!');
    }


    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
        $this->capacity = $classroom->capacity;
        $this->grade = $classroom->grade;
        $this->name = $classroom->name;
    }

    public function render()
    {
        return view('livewire.admin.classroom.edit-classroom');
    }
}
