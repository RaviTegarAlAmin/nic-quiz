<?php

namespace App\Livewire\Admin\Student;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class EditStudent extends Component
{
    /* ---------------------------------
       Identity
    ----------------------------------*/
    public int $studentId;


    /* ---------------------------------
       Form Properties (Live Validation)
    ----------------------------------*/
    #[Validate]
    public ?string $name = null;

    #[Validate]
    public ?string $gender = '';

    #[Validate]
    public ?string $address = null;

    #[Validate]
    public ?string $born_date = null;

    /* ---------------------------------
       Mount (Load Existing Data)
    ----------------------------------*/
    public function mount(int $studentId): void
    {
        $student = Student::with('user')->findOrFail($studentId);

        $this->studentId = $student->id;

        $this->fill([
            'name' => $student->name,
            'gender' => $student->gender,
            'address' => $student->address,
            'born_date' => $student->born_date
        ]);
    }

    /* ---------------------------------
       Validation Rules
    ----------------------------------*/
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'address' => 'required|string|min:5|max:512',
            'born_date' => 'required|date|before:now',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Isi nama siswa',
            'name.max' => 'Nama Siswa terlalu panjang',
            'gender.required' => 'Gender harus diisi',
            'gender.in' => 'Gender tidak sesuai',
            'address.required' => 'Alamat wajib diisi',
            'address.min' => 'Alamat terlalu pendek',
            'address.max' => 'Alamat terlalu panjang',
            'born_date.required' => 'Tanggal lahir wajib diisi',
            'born_date.before' => 'Tanggal lahir tidak sesuai',
        ];
    }

    /* ---------------------------------
       Reset Form State
    ----------------------------------*/
    public function resetForm(): void
    {
        $this->reset('name', 'address', 'born_date', 'gender');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    /* ---------------------------------
       Update Student
    ----------------------------------*/
    public function updateStudent(): void
    {
        $validated = $this->validate();

        try {

            DB::transaction(function () use ($validated) {

                $student = Student::with('user')->findOrFail($this->studentId);

                $student->update([
                    'name' => $validated['name'],
                    'gender' => $validated['gender'],
                    'born_date' => $validated['born_date'],
                    'address' => $validated['address'],
                ]);

                // Keep User name in sync
                if ($student->user) {
                    $student->user->update([
                        'name' => $validated['name'],
                    ]);
                }
            });

            $this->dispatch('refresh-table');

            $this->dispatch('close-edit-modal');

            $this->dispatch('show-toast', [
                'message' => 'Siswa Berhasil Diperbarui',
                'type' => 'success',
            ]);



        } catch (\Throwable $e) {

            report($e);

            $this->dispatch('show-toast', [
                'message' => 'Siswa Gagal Diperbarui',
                'type' => 'failed',
            ]);
        }
    }

    /* ---------------------------------
       Render
    ----------------------------------*/
    public function render()
    {
        return view('livewire.admin.student.edit-student');
    }
}
