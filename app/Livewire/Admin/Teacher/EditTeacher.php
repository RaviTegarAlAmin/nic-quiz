<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditTeacher extends Component
{
    public int $teacherId;
    public ?string $name = null;
    public ?string $nip = null;
    public ?string $gender = '';
    public ?string $born_date = null;
    public ?string $address = null;

    public function mount(int $teacherId): void
    {
        $teacher = Teacher::findOrFail($teacherId);

        $this->name = $teacher->name;
        $this->nip = $teacher->nip;
        $this->gender = $teacher->gender;
        $this->born_date = $teacher->born_date;
        $this->address = $teacher->address;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'nip' => ['required', 'string', 'max:100', Rule::unique('teachers', 'nip')->ignore($this->teacherId)],
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'born_date' => 'required|date|before:now',
            'address' => 'required|string|min:5|max:512',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $teacher = Teacher::with('user')->findOrFail($this->teacherId);

        try {
            DB::transaction(function () use ($teacher, $validated) {
                $user = $teacher->user ?? User::create([
                    'name' => $validated['name'],
                    'email' => strtolower($validated['nip']) . '@mtsnic.com',
                    'password' => Hash::make('password'),
                ]);

                $user->update([
                    'name' => $validated['name'],
                    'email' => strtolower($validated['nip']) . '@mtsnic.com',
                ]);

                $teacher->update([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'nip' => $validated['nip'],
                    'gender' => $validated['gender'],
                    'born_date' => $validated['born_date'],
                    'address' => $validated['address'],
                ]);
            });

            $this->dispatch('refresh-teacher-table');
            $this->dispatch('close-teacher-edit');
            $this->dispatch('show-toast', [
                'message' => 'Guru berhasil diperbarui',
                'type' => 'success',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('show-toast', [
                'message' => 'Guru gagal diperbarui',
                'type' => 'failed',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.teacher.edit-teacher');
    }
}
