<?php

namespace App\Livewire\Admin\Classroom\Form;

use App\Services\Classroom\ClassroomActionService;
use Livewire\Component;

final class DeleteClassroom extends Component
{
    public int $classroomId;
    public string $classroomName = '';
    public int $totalStudents = 0;

    public string $confirmationInput = '';

    public bool $isDeleting = false;

    public function mount(array $classroom): void
    {
        $this->classroomId = $classroom['id'];
        $this->classroomName = $classroom['name'] ?? '';
        $this->totalStudents = (int) ($classroom['total_students'] ?? 0);
    }

    public function getExpectedPhraseProperty(): string
    {
        return 'HAPUS KELAS ' . strtoupper($this->classroomName);
    }

    public function messages(){
        return [
            'confirmationInput.required' => 'Harus diisi',
            'confirmationInput.string' => 'Format konfirmasi salah'
        ];
    }

    public function delete(ClassroomActionService $cas): void
    {
        $this->validate([
            'confirmationInput' => ['required', 'string'],
        ]);

        if (strtoupper(trim($this->confirmationInput)) !== $this->expectedPhrase) {
            $this->addError('confirmationInput', 'Konfirmasi tidak sesuai. Ketik persis seperti yang diminta.');
            return;
        }

        $this->isDeleting = true;

        try {
            $cas->deleteClassroom($this->classroomId);

            $this->dispatch('classroom-deleted', classroomId: $this->classroomId);
            $this->dispatch('close-edit');

            $this->dispatch('show-toast', [
                'message' => 'Kelas Berhasil Dihapus',
                'type' => 'success',
            ]);
        } catch (\Throwable $e) {
            $this->isDeleting = false;

            $this->dispatch('show-toast', [
                'message' => 'Kelas Gagal Dihapus',
                'type' => 'failed',
            ]);
        }
    }

    public function cancel(): void
    {
        $this->dispatch('close-edit');
    }

    public function render()
    {
        return view('livewire.admin.classroom.form.delete-classroom');
    }
}
