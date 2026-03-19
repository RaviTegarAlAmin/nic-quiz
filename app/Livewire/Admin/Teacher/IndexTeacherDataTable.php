<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class IndexTeacherDataTable extends Component
{
    public string $search = '';

    #[On('refresh-teacher-table')]
    public function render()
    {
        $teachers = Teacher::query()
            ->with('user')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nip', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->get();

        return view('livewire.admin.teacher.index-teacher-data-table', [
            'teachers' => $teachers,
        ]);
    }
}
