<?php

namespace App\Livewire\Admin\Classroom;

use App\Services\Classroom\ClassroomActionService;
use App\Services\Classroom\ClassroomQueryService;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IndexLeftPanel extends Component
{
    public ?array $classrooms = [];

    #[Validate('required|string|max:50')]
    public ?string $name = null;

    #[Validate('required|integer|min:1')]
    public ?int $grade = null;

    #[Validate('required|integer|min:1')]
    public ?int $capacity = null;

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama kelas wajib diisi.',
            'name.string' => 'Nama kelas harus berupa teks.',
            'name.max' => 'Nama kelas maksimal 50 karakter.',
            'grade.required' => 'Tingkat kelas wajib dipilih.',
            'grade.integer' => 'Tingkat kelas harus berupa angka.',
            'grade.min' => 'Tingkat kelas minimal 1.',
            'capacity.required' => 'Kapasitas wajib diisi.',
            'capacity.integer' => 'Kapasitas harus berupa angka.',
            'capacity.min' => 'Kapasitas minimal 1.',
        ];
    }

    public function createClassroom(
        ClassroomActionService $service,
        ClassroomQueryService $cqs
    ) {
        $this->validate();

        try {
            $service->createClassroom($this->name, $this->grade, $this->capacity);
            $this->refreshClassrooms($cqs);
            $this->reset('name', 'grade', 'capacity');

            $this->dispatch('show-toast', [
                'message' => 'Kelas Berhasil Dibuat',
                'type' => 'success',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('show-toast', [
                'message' => 'Kelas Gagal Dibuat',
                'type' => 'failed',
            ]);
        }
    }

    public function mount(ClassroomQueryService $cqs)
    {
        $this->refreshClassrooms($cqs);
    }

    protected function refreshClassrooms(ClassroomQueryService $cqs): void
    {
        $payload = $cqs->getAllClassroomsWithSummary();
        $this->classrooms = count($payload) > 0
            ? $this->mapClassroomsByGrade($payload)
            : [];
    }

    protected function mapClassroomsByGrade(array $payload): array
    {
        $mapped = [];

        foreach ($payload as $data) {
            $grade = $data['grade'];
            unset($data['grade']);
            $mapped[$grade][] = $data;
        }

        return $mapped;
    }

    /**
     * Fired by EditClassroomProfile / EditHomeroomTeacher after a successful save.
     * Updates the matching preview row in place, without requerying the whole list.
     */
    #[On('classroom-edited')]
    public function classroomEdited(array $classroom): void
    {
        foreach ($this->classrooms as $grade => $rows) {
            foreach ($rows as $i => $row) {
                if ($row['id'] !== $classroom['id']) {
                    continue;
                }

                $merged = array_merge($row, $classroom);
                $newGrade = $merged['grade'] ?? $grade;
                unset($merged['grade']);

                // Same grade bucket: update in place.
                if ($newGrade === $grade) {
                    $this->classrooms[$grade][$i] = $merged;
                    return;
                }

                // Grade changed: move the row to its new bucket.
                unset($this->classrooms[$grade][$i]);
                $this->classrooms[$grade] = array_values($this->classrooms[$grade]);

                if (empty($this->classrooms[$grade])) {
                    unset($this->classrooms[$grade]);
                }

                $this->classrooms[$newGrade][] = $merged;

                return;
            }
        }
    }

    /**
     * Fired by DeleteClassroom after a successful delete.
     */
    #[On('classroom-deleted')]
    public function classroomDeleted(int $classroomId): void
    {
        foreach ($this->classrooms as $grade => $rows) {
            foreach ($rows as $i => $row) {
                if ($row['id'] !== $classroomId) {
                    continue;
                }

                unset($this->classrooms[$grade][$i]);
                $this->classrooms[$grade] = array_values($this->classrooms[$grade]);

                if (empty($this->classrooms[$grade])) {
                    unset($this->classrooms[$grade]);
                }

                return;
            }
        }
    }

    #[On('homeroom-teacher-edited')]
    public function homeroomTeacherEdited(array $classroom): void
    {
        foreach ($this->classrooms as $grade => $rows) {
            foreach ($rows as $i => $row) {
                if ($row['id'] !== $classroom['id']) {
                    continue;
                }

                $this->classrooms[$grade][$i] = array_merge($row, [
                    'teacher_id' => $classroom['homeroom_teacher_id'],
                    'homeroom_teacher' => $classroom['homeroom_teacher_name'],
                ]);

                return;
            }
        }
    }

    #[On('homeroom-teacher-deleted')]
    public function homeroomTeacherDeleted(int $classroomId): void
    {
        foreach ($this->classrooms as $grade => $rows) {
            foreach ($rows as $i => $row) {
                if ($row['id'] !== $classroomId) {
                    continue;
                }

                $this->classrooms[$grade][$i]['teacher_id'] = null;
                $this->classrooms[$grade][$i]['homeroom_teacher'] = null;
                return;
            }
        }
    }

    public function placeholder()
    {
        return view('livewire.admin.classroom.index-left-panel-placeholder');
    }

    public function render()
    {
        return view('livewire.admin.classroom.index-left-panel');
    }
}
