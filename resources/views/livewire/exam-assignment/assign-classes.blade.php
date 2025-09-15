{{-- THIS IS MOVED FROM ADD EXAM AFTER MIGRATING NEW EXAMASSINGMENT MODEL --}}
<div >
    <x-card x-data="{ modal: false }">
        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2 flex">
                <div class="flex gap-0">
                    <x-label class="mr-0">Judul</x-label>
                    <div class=" p-1.5 mr-3 text-secondary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                            <circle cx="12" cy="16" r="1" />
                            <rect x="3" y="10" width="18" height="12" rx="2" />
                            <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <x-form-input disabled :value="$exam->title" name="{{ $exam->title }}" />
                </div>
            </div>

            <div class="flex">
                <div class="flex gap-0">
                    <x-label class="mr-0">Mata Pelajaran</x-label>
                    <div class=" p-1.5 mr-3 text-secondary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                            <circle cx="12" cy="16" r="1" />
                            <rect x="3" y="10" width="18" height="12" rx="2" />
                            <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <x-form-input :value="$exam->course->name" disabled name="{{ $exam->course->name }}"></x-form-input>
                </div>
            </div>

            <div class="flex">
                <div><x-label for="start_at" class="mr-3">Mulai</x-label></div>
                <div class="flex-1">
                    <x-form-input type="datetime-local" id="start_at" wire:model.live="start_at" name="start_at"
                        placeholder="Waktu mulai..." />
                </div>
            </div>

            <div class="flex">
                <div><x-label for="end_at" class="mr-3">Akhir</x-label></div>
                <div class="flex-1">
                    <x-form-input name="end_at" type="datetime-local" id="end_at" wire:model.live="end_at" />
                </div>
            </div>

            <div class="flex">
                <div><x-label for="duration" class="mr-3">Durasi</x-label></div>
                <div class="flex-1">
                    <x-form-input name="duration" type="number" id="duration" wire:model.live="duration"
                        placeholder="Waktu dalam menit..." />
                </div>
            </div>
        </div>

        <div>
            <x-label class=" mb-5">Pilih Kelas</x-label>
            <div class=" flex gap-2 mb-4">
                @foreach ($teachings as $teaching)
                    <div wire:key="teaching-{{ $teaching->id }}">
                        <x-class-status-tag class=" hover:bg-secondary-400/60 hover:text-white "
                            wire:click="toggleAssignedTeaching({{ $teaching->id }})"
                            status="{{ in_array($teaching->id, $assignedTeaching) ? 'clicked' : null }} ">{{ $teaching->classroom->name }}
                        </x-class-status-tag>
                    </div>
                @endforeach
            </div>
        </div>

        <x-submit-button x-on:click="modal=!modal">Buat Penugasan Baru</x-submit-button>

        <x-modal message="Tambahkan Penugasan Pada Kelas?">
            <x-submit-button class=" bg-success-700" wire:click="assignExam"
                x-on:click="modal=!modal">Ya</x-submit-button>
        </x-modal>
    </x-card>

    {{-- Table for Exam Assignments --}}

    <div class=" mt-4">
        <x-header>Daftar Penugasan</x-header>
        <livewire:data-table :model-id="$exam->id" :columns="[
            ['label' => 'Mulai', 'field' => 'start_at'],
            ['label' => 'Akhir', 'field' => 'end_at'],
            ['label' => 'Durasi', 'field' => 'duration'],
            ['label' => 'Kelas', 'field' => 'teaching.classroom.name']
        ]"
        >

        </livewire:data-table>
    </div>

    {{-- Toast --}}

    <div x-data="{
        toast: false,
        message: '',
        type: 'success'
    }"
        x-on:show-toast.window="
        toast = true;
        message = $event.detail[0].message || '';
        type = $event.detail[0].type || 'success';
     ">

        <x-toast />

    </div>


</div>
