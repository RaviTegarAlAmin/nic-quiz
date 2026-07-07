<div class="flex h-full min-h-0 flex-col">

    {{-- Buat Kelas Baru --}}
    <div x-data="{ open: false }" class="mb-3 flex-shrink-0">
        <x-button variant="success" class="w-full" x-on:click="open = !open">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white opacity-20"></div>
            <span>Buat Kelas Baru</span>
            +
        </x-button>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            <x-card class="mt-3 !rounded-t-none">
                <div class="space-y-2">
                    <x-form wire:model="name" name="name" label="Nama Kelas" type="text"
                        placeholder="Nama kelas (contoh: 9D)"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-secondary-400" />
                    <select wire:model="grade" name="grade" wire:loading.attr="disabled" wire:target="CClassroom"
                        class="w-full rounded-lg border px-3 py-2 text-gray-500 hover:shadow-md focus:outline-none focus:border-secondary-400 disabled:cursor-not-allowed disabled:opacity-60 {{ $errors->has('grade') ? 'border-danger-500' : 'border-gray-200' }}">
                        <option value="">Pilih Tingkat</option>
                        @foreach ($classrooms as $grade => $classroom)
                            <option value="{{ $grade }}">{{ $grade }}</option>
                        @endforeach
                    </select>
                    @error('grade')
                        <div class="mt-1 text-danger-500 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                    <x-form wire:model="capacity" name="capacity" label="Kapasitas" type="number"
                        placeholder="Kapasitas"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-secondary-400" />
                    <div class="space-y-2">
                        <x-button wire:click="createClassroom()" wire:loading.attr="disabled"
                            wire:target="createClassroom" variant="secondary"
                            class="w-full disabled:cursor-not-allowed disabled:opacity-60">
                            <span wire:loading.remove wire:target="createClassroom">+ Tambah Kelas</span>
                            <span wire:loading wire:target="createClassroom">Menyimpan...</span>
                        </x-button>

                        <div wire:loading wire:target="createClassroom"
                            class="rounded-lg border border-secondary-200 bg-secondary-50 px-3 py-2 text-xs text-secondary-700">
                            Menyimpan data kelas. Mohon tunggu...
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    {{-- Classroom List --}}
    <x-ui.detail-card
        class="mb-3 flex-shrink-0 relative overflow-hidden flex items-center border-l-4 border-warning-600 !bg-warning-600/70 font-bold text-gray-600 !text-sm">
        <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white opacity-20"></div>
        Daftar Kelas
    </x-ui.detail-card>

    <div x-data="{ selectedClassroom: null }"
        class="max-h-[22rem] md:max-h-none md:flex-1 min-h-0 overflow-y-auto flex flex-col gap-2 pr-1">
        @foreach ($classrooms as $gradeLevel => $classroomGroup)
            @foreach ($classroomGroup as $classroom)
                <x-card
                    @click="selectedClassroom = {{ $classroom['id'] }};
                $dispatch('classroom-selected', {classroomId: {{ $classroom['id'] }}})"
                    wire:key="{{ $classroom['id'] }}" class="cursor-pointer transition-colors"
                    x-bind:class="selectedClassroom === {{ $classroom['id'] }} ? 'border-2 !border-secondary-500' :
                        'border border-transparent hover:border-secondary-200'"
                    x-bind:style="selectedClassroom === {{ $classroom['id'] }} ? 'box-shadow: 2px 2px 0 #3C3489' : ''">
                    <div class="flex justify-between items-center mb-1.5">
                        <div class="font-medium text-sm text-gray-800">{{ $classroom['name'] }}</div>
                        <div class="text-xs text-gray-500">
                            Wali Kelas: <span
                                class="font-medium text-gray-700">{{ $classroom['homeroom_teacher'] ?? 'Belum ditentukan' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-1.5">
                        <span
                            class="text-xs bg-secondary-50 text-secondary-700 border border-secondary-200 rounded-full px-2 py-0.5">
                            Kelas {{ $gradeLevel }}
                        </span>

                        <div class="flex-1 h-1 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-1 rounded-full bg-secondary-400"
                                style="width: {{ $classroom['occupancy'] ?? 0 }}%"></div>
                        </div>

                        <span class="text-xs text-gray-400">{{ $classroom['occupancy'] ?? 0 }}%</span>
                    </div>
                </x-card>
            @endforeach
        @endforeach
    </div>

    <x-ui.toast></x-ui.toast>

</div>
