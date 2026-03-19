<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DeleteTeacher extends Component
{
    public int $teacherId;

    public function delete(): void
    {
        $teacher = Teacher::with('user')->findOrFail($this->teacherId);

        try {
            DB::transaction(function () use ($teacher) {
                if ($teacher->user) {
                    $teacher->user->delete();
                    return;
                }

                $teacher->delete();
            });

            $this->dispatch('refresh-teacher-table');
            $this->dispatch('close-teacher-delete');
            $this->dispatch('show-toast', [
                'message' => 'Guru berhasil dihapus',
                'type' => 'success',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('show-toast', [
                'message' => 'Guru gagal dihapus',
                'type' => 'failed',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.teacher.delete-teacher', [
            'teacher' => Teacher::find($this->teacherId),
        ]);
    }
}
