<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class IndexTeacher extends Component
{
    public bool $modalAdd = false;
    public bool $modalEdit = false;
    public bool $modalDelete = false;
    public ?int $selectedTeacherId = null;

    public function openAddModal(): void
    {
        $this->modalAdd = true;
    }

    #[On('close-teacher-add')]
    public function closeAddModal(): void
    {
        $this->modalAdd = false;
    }

    #[On('open-teacher-edit')]
    public function openEditModal(int $teacherId): void
    {
        $this->selectedTeacherId = $teacherId;
        $this->modalEdit = true;
    }

    #[On('close-teacher-edit')]
    public function closeEditModal(): void
    {
        $this->modalEdit = false;
        $this->selectedTeacherId = null;
    }

    #[On('open-teacher-delete')]
    public function openDeleteModal(int $teacherId): void
    {
        $this->selectedTeacherId = $teacherId;
        $this->modalDelete = true;
    }

    #[On('close-teacher-delete')]
    public function closeDeleteModal(): void
    {
        $this->modalDelete = false;
        $this->selectedTeacherId = null;
    }

    #[On('refresh-teacher-table')]
    public function render()
    {
        $stats = [
            'total' => Teacher::count(),
            'male' => Teacher::where('gender', 'Laki-Laki')->count(),
            'female' => Teacher::where('gender', 'Perempuan')->count(),
        ];

        return view('livewire.admin.teacher.index-teacher', [
            'stats' => $stats,
        ]);
    }
}
