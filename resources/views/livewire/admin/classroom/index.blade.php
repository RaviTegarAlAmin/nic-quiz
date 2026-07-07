<div x-data="{ classroomSelected: $wire.entangle('classroomSelected') }" class="flex flex-col md:h-full md:min-h-0">

    <div x-show="!classroomSelected">
        <x-header>Manajemen Kelas</x-header>
    </div>

    <div class="flex-1 flex flex-col md:flex-row gap-3 md:min-h-0 mb-6 md:mb-0">

        {{-- Left Panel --}}
        <div class="w-full md:w-64 lg:w-72 flex-shrink-0 flex flex-col gap-3 md:min-h-0">
            <x-header x-show="classroomSelected" class="!mb-1">
                Manajemen Kelas
            </x-header>
            <livewire:admin.classroom.index-left-panel lazy />
        </div>

        {{-- Right Panel Wrapper --}}
        <div class="min-h-[60vh] flex flex-col md:flex-1 md:min-h-0 min-w-0 overflow-hidden">
            <livewire:admin.classroom.index-right-panel lazy />
        </div>

    </div>



</div>
