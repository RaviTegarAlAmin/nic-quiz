<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddStudent extends Component
{

    public int $classroomId;

    #[Validate]
    public ?string $name = null;

    #[Validate]
    public ?string $gender = '';

    #[Validate]
    public ?string $address = null;

    #[Validate]
    public ?string $born_date = null;



    /* Data Validation */
    protected function rules()
    {

        return [
            'name' => 'required|string|max:100',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'address' => 'required|string|min:5|max:512',
            'born_date' => 'required|date|before:now'
        ];

    }

    protected function messages()
    {

        return [
            'name.required' => 'Isi nama siswa',
            'name.max' => 'Nama Siswa terlalu panjang',
            'gender.required' => 'Gender harus diisi',
            'gender.in' => 'Gender tidak sesuai',
            'address.required' => 'Alamat wajib diisi',
            'address.max' => 'Alamat terlalu panjang',
            'address.min' => 'Alamat terlalu pendek',
            'born_date.required' => 'Tanggal lahir wajib diisi',
            'born_date.before' => 'Tanggal lahir tidak sesuai'
        ];
    }



    /* Reset attributes properties */
    public function resetForm()
    {

        $this->reset('name', 'address', 'born_date', 'gender');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /* Saving student's data */

    public function addStudent()
    {

        $validated = $this->validate();

        $rand = fake()->numberBetween(1, 1000);

        try {

            DB::transaction(function () use ($validated, $rand) {

                $newUser = User::create([
                    'name' => $validated['name'],
                    'email' => "student{$rand}@nic.com",
                    'password' => Hash::make('password')
                ]);

                Student::create([
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'born_date' => $validated['born_date'],
                    'address' => $validated['address'],

                    'classroom_id' => $this->classroomId,
                    'user_id' => $newUser->id,

                    'nis' => "202600{$rand}"
                ]);
            });

            $this->dispatch('refresh-table');

            $this->dispatch('show-toast', [
                'message' => 'Siswa Berhasil Ditambahkan',
                'type' => 'success'
            ]);

            $this->resetForm();



        } catch (\Throwable $th) {

            $this->dispatch('show-toast', [
                'message' => 'Siswa Gagal Ditambahkan',
                'type' => 'failed'
            ]);

            $this->modalform = false;

        }

    }





    public function render()
    {
        return view('livewire.admin.student.add-student');
    }
}
