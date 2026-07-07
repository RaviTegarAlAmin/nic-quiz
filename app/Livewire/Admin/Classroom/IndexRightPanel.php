<?php

namespace App\Livewire\Admin\Classroom;

use App\Services\Classroom\ClassroomQueryService;
use App\Services\Schedule\ScheduleService;
use App\Services\Student\StudentQueryService;
use App\Services\Teaching\TeachingQueryService;
use Livewire\Attributes\On;
use Livewire\Component;

class IndexRightPanel extends Component
{
    public string $activeTab = 'overview';

    public ?int $selectedClassroomId = null;

    public array $cachedOverview = [];
    public array $cachedStudents = [];
    public array $cachedSchedules = [];
    public array $cachedTeachings = [];

    public array $currentClassroomOverview = [];
    public array $currentClassroomStudents = [];
    public array $currentClassroomSchedules = [];
    public array $currentClassroomTeachings = [];

    public ?string $activeEdit = null;

    #[On('classroom-selected')]
    public function selectClassroom(
        int $classroomId,
        ClassroomQueryService $classroomQueryService
    ): void {
        $this->selectedClassroomId = $classroomId;
        $this->activeTab = 'overview';
        $this->activeEdit = null;

        $this->loadOverview($classroomQueryService);
    }

    public function selectTab(
        string $tab,
        ClassroomQueryService $classroomQueryService,
        ScheduleService $scheduleService,
        StudentQueryService $studentQueryService,
        TeachingQueryService $teachingQueryService
    ): void {
        $this->activeTab = $tab;

        match ($tab) {
            'overview' => $this->loadOverview($classroomQueryService),
            'students' => $this->loadStudents($studentQueryService),
            'schedules' => $this->loadSchedules($scheduleService),
            'teachings' => $this->loadTeachings($teachingQueryService),
            default => null,
        };
    }

    private function loadOverview(ClassroomQueryService $classroomQueryService): void
    {
        $this->loadCurrentData(
            $this->cachedOverview,
            'currentClassroomOverview',
            $this->selectedClassroomId,
            fn() => $classroomQueryService->getClassroomOverview($this->selectedClassroomId)
        );
    }

    private function loadStudents(StudentQueryService $studentQueryService): void
    {
        $this->loadCurrentData(
            $this->cachedStudents,
            'currentClassroomStudents',
            $this->selectedClassroomId,
            fn() => $studentQueryService->getStudentsByClassroomId($this->selectedClassroomId)
        );
    }

    private function loadSchedules(ScheduleService $scheduleService): void
    {
        $this->loadCurrentData(
            $this->cachedSchedules,
            'currentClassroomSchedules',
            $this->selectedClassroomId,
            fn() => $scheduleService->getMappedSchedulesByClassroomId($this->selectedClassroomId)
        );
    }

    private function loadTeachings(TeachingQueryService $teachingQueryService): void
    {
        $this->loadCurrentData(
            $this->cachedTeachings,
            'currentClassroomTeachings',
            $this->selectedClassroomId,
            fn() => $teachingQueryService->getTeachingsByClassroomId($this->selectedClassroomId)
        );
    }

    private function loadCurrentData(
        array &$cache,
        string $currentProperty,
        int $classroomId,
        callable $callback
    ): void {
        if (!isset($cache[$classroomId])) {
            $cache[$classroomId] = $callback();
        }

        $this->{$currentProperty} = $cache[$classroomId];
    }

    public function placeholder()
    {
        return view('livewire.admin.classroom.index-right-panel-placeholder');
    }

    /**
     * Fired by EditClassroomProfile / EditHomeroomTeacher / Delete Classroom / Close edit component after a successful save.
     * Expects at minimum ['id' => int, ...changed fields].
     */

    /*
    Fired by \admin\classroom\form\edit-classroom after succesful edit
    */
    #[On('classroom-edited')]
    public function classroomEdited(array $classroom): void
    {
        $this->activeEdit = null;

        $classroomId = $classroom['id'];

        $this->cachedOverview[$classroomId] = array_merge(
            $this->cachedOverview[$classroomId] ?? [],
            $classroom
        );

        if ($classroomId === $this->selectedClassroomId) {
            $this->currentClassroomOverview = $this->cachedOverview[$classroomId];
        }

        $this->dispatch('show-toast', [
            'message' => 'Kelas Berhasil Diubah',
            'type' => 'success',
        ]);
    }

    /**
     * Fired by DeleteClassroom after a successful delete.
     */


    #[On('classroom-deleted')]
    public function classroomDeleted(int $classroomId): void
    {
        unset(
            $this->cachedOverview[$classroomId],
            $this->cachedStudents[$classroomId],
            $this->cachedSchedules[$classroomId],
            $this->cachedTeachings[$classroomId],
        );

        if ($classroomId === $this->selectedClassroomId) {
            $this->selectedClassroomId = null;
            $this->activeTab = 'overview';
            $this->activeEdit = null;
            $this->currentClassroomOverview = [];
            $this->currentClassroomStudents = [];
            $this->currentClassroomSchedules = [];
            $this->currentClassroomTeachings = [];
        }

        $this->dispatch('show-toast', [
            'message' => 'Kelas Berhasil Dihapus',
            'type' => 'success',
        ]);
    }

    #[On('homeroom-teacher-edited')]
    public function homeroomTeacherEdited(array $classroom): void
    {
        $this->activeEdit = null;

        $classroomId = $classroom['id'];

        $this->cachedOverview[$classroomId] = array_merge(
            $this->cachedOverview[$classroomId] ?? [],
            $classroom
        );

        if ($classroomId === $this->selectedClassroomId) {
            $this->currentClassroomOverview = $this->cachedOverview[$classroomId];
        }

        $this->dispatch('show-toast', [
            'message' => 'Wali Kelas Berhasil Diubah',
            'type' => 'success',
        ]);
    }

    #[On('homeroom-teacher-deleted')]
    public function homeroomTeacherDeleted(int $classroomId): void
    {
        $this->activeEdit = null;

        $this->cachedOverview[$classroomId]['teacher_id'] = null;
        $this->cachedOverview[$classroomId]['homeroom_teacher_name'] = null;
        $this->cachedOverview[$classroomId]['gender'] = null;
        $this->cachedOverview[$classroomId]['nip'] = null;
        $this->cachedOverview[$classroomId]['subjects'] = null;

        $this->currentClassroomOverview = $this->cachedOverview[$classroomId] ?? [];

        $this->dispatch('show-toast', [
            'message' => 'Wali Kelas Dihapus',
            'type' => 'warning',
        ]);

        $this->dispatch('close-edit');
    }

    #[On('close-edit')]
    public function closeEdit()
    {
        $this->activeEdit = null;
    }

    public function render()
    {
        return view('livewire.admin.classroom.index-right-panel');
    }
}
