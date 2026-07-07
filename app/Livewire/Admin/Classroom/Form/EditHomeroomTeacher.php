<?php

namespace App\Livewire\Admin\Classroom\Form;

use App\Models\Classroom;
use App\Models\Teacher;
use App\Services\Classroom\ClassroomActionService;
use Livewire\Component;

class EditHomeroomTeacher extends Component
{
    public int $classroomId;
    public ?array $classroomData = null;
    public ?int $selectedTeacherId = null;

    /** @var array<int, array{id:int,name:string,nip:?string}> */
    public array $teachers = [];

    public function mount(array $classroom): void
    {
        $this->classroomData = $classroom;
        $this->classroomId = $classroom['id'];
        $this->selectedTeacherId = $classroom['homeroom_teacher_id'] ?? null;

        $this->teachers = Teacher::query()
            ->select(['id', 'name', 'nip'])
            ->orderBy('name')
            ->get()
            ->map(fn(Teacher $teacher) => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'nip' => $teacher->nip,
            ])
            ->all();
    }

    public function save(ClassroomActionService $cas): void
    {
        $this->validate([
            'selectedTeacherId' => ['required', 'exists:teachers,id'],
        ]);

        $cas->changeHomeroomTeacher($this->classroomId, $this->selectedTeacherId);

        $this->dispatch('homeroom-teacher-edited', classroom: [
            'id' => $this->classroomId,
            'homeroom_teacher_id' => $this->selectedTeacherId,
            'homeroom_teacher_name' => collect($this->teachers)->firstWhere('id', $this->selectedTeacherId)['name'] ?? null,
        ]);
        $this->dispatch('close-edit');
    }

    public function deleteHomeroomTeacher(ClassroomActionService $cas)
    {

        $cas->removeHomeroomTeacher($this->classroomId);

        $this->dispatch('homeroom-teacher-deleted', classroomId: $this->classroomId);
        $this->dispatch('close-edit');

    }

    public function render()
    {
        return view('livewire.admin.classroom.form.edit-homeroom-teacher');
    }
}
