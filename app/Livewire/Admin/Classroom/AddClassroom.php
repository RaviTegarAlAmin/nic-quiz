<?php

namespace App\Livewire\Admin\Classroom;

use App\Models\Classroom;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddClassroom extends Component
{
    // Eloquent Data

    public $newClassroom;

    //Properties
    #[Validate]
    public int $capacity = 32;

    #[Validate]
    public string $name = '';

    #[Validate]
    public string $grade = '7';

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:classrooms,name',
            'grade' => 'required|string',
            'capacity' => 'required|integer|min:1|max:36'
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Isi nama kelas',
            'name.unique' => 'Kelas sudah ada',
            'name.min' => 'Karakter nama kelas kurang',
            'name.max' => 'Nama kelas terlalu panjang',
            'capacity.required' => 'Kapasitas harus diisi',
            'capacity.min' => 'Kapasitas tidak sesuai',
            'capacity.max' => 'Kapasitas tidak sesuai'
        ];
    }

    public function addClassroom()
    {
        $validated = $this->validate();

        $this->newClassroom = Classroom::create([
            'grade' =>  $validated['grade'],
            'name' => $validated['name'],
            'capacity' => $validated['capacity']
        ]);

        return redirect()->route('admin.classrooms.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }


    public function render()
    {
        return view('livewire.admin.classroom.add-classroom');
    }
}
