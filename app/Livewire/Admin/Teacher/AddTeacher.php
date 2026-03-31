<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddTeacher extends Component
{
    public ?string $name = null;
    public ?string $nip = null;
    public ?string $gender = '';
    public ?string $born_date = null;
    public ?string $address = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'nip' => 'required|string|max:100|unique:teachers,nip',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'born_date' => 'required|date|before:now',
            'address' => 'required|string|min:5|max:512',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        try {
            DB::transaction(function () use ($validated) {
                $user = User::updateOrCreate(
                    ['email' => strtolower($validated['nip']) . '@mtsnic.com'],
                    [
                        'name' => $validated['name'],
                        'password' => Hash::make('password'),
                    ]
                );

                Teacher::create([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'nip' => $validated['nip'],
                    'gender' => $validated['gender'],
                    'born_date' => $validated['born_date'],
                    'address' => $validated['address'],
                ]);
            });


            $this->reset('name', 'nip', 'gender', 'born_date', 'address');
            $this->resetValidation();
            $this->dispatch('refresh-teacher-table');
            $this->dispatch('close-teacher-add');
            $this->dispatch('show-toast', [
                'message' => 'Guru berhasil ditambahkan',
                'type' => 'success',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('show-toast', [
                'message' => 'Guru gagal ditambahkan',
                'type' => 'failed',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.teacher.add-teacher');
    }
}
