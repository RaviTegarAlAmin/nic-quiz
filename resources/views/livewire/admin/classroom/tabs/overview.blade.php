<div class="h-full">


    <div class="mx-auto flex h-full w-full max-w-3xl flex-col justify-start px-4 py-4">
        <div
            class="rounded-2xl border border-gray-200 bg-gradient-to-br from-white via-warning-50/40 to-secondary-50/60 p-5 shadow-sm">

            {{-- Header --}}
            <div class="flex items-center gap-4">
                <div
                    class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full border-4 border-white bg-gray-100 shadow-sm">
                    <img src="{{ asset('assets/logo/default-profile.png') }}" alt="Default profile"
                        class="h-full w-full object-cover">
                </div>

                <div class="flex-1 min-w-0 text-left">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-gray-400">
                        Wali Kelas
                    </p>
                    <h3 class="mt-1 truncate text-lg font-bold text-gray-800">
                        {{ $currentClassroomOverview['homeroom_teacher_name'] ?? 'Belum ditentukan' }}
                    </h3>
                    <p class="mt-0.5 text-sm text-gray-500">
                        {{ !empty($currentClassroomOverview['nip']) ? 'NIP ' . $currentClassroomOverview['nip'] : '-' }}
                    </p>
                </div>

                <div x-show="!activeEdit" class="flex-shrink-0">
                    @if (empty($currentClassroomOverview['homeroom_teacher_name']))
                        <x-button @click="activeEdit = 'homeroom'" variant="secondary"
                            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
                            Atur Wali Kelas
                        </x-button>
                    @else
                        <x-button @click="activeEdit = 'homeroom'" variant="warning"
                            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
                            Ganti Wali Kelas
                        </x-button>
                    @endif
                </div>
            </div>

            {{-- Homeroom edit form --}}
            <div x-show="activeEdit === 'homeroom'" x-cloak class="mt-4">
                <livewire:admin.classroom.form.edit-homeroom-teacher :classroom="$currentClassroomOverview" :key="'edit-homeroom-' . $currentClassroomOverview['id']" />
            </div>

            {{-- Tags and Action Button --}}
            <div class="mt-4">
                <div class=" md:flex md:justify-between">
                    <div x-show="!activeEdit" class="flex flex-wrap items-center gap-2">
                        <span
                            class="rounded-full border border-secondary-200 bg-secondary-50 px-3 py-1 text-xs font-medium text-secondary-700">
                            Kelas {{ $currentClassroomOverview['name'] ?? '-' }}
                        </span>
                        <span
                            class="rounded-full border border-warning-200 bg-warning-50 px-3 py-1 text-xs font-medium text-warning-700">
                            Tingkat {{ $currentClassroomOverview['grade'] ?? '-' }}
                        </span>
                        <span
                            class="rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">
                            Kapasitas {{ (int) ($currentClassroomOverview['capacity'] ?? 0) }}
                        </span>
                        @if (!empty($currentClassroomOverview['subjects']))
                            @foreach (explode(', ', $currentClassroomOverview['subjects']) as $subject)
                                <span
                                    class="rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-medium text-gray-600">
                                    {{ $subject }}
                                </span>
                            @endforeach
                        @endif

                    </div>

                    <div x-show="!activeEdit" class="flex gap-2 relative z-10">
                        <x-button variant="warning" @click="activeEdit = (activeEdit === 'profile' ? null : 'profile')"
                            class="!w-auto !rounded-lg !px-2.5 !py-0.5 !text-xs">
                            Edit
                        </x-button>

                        <x-button variant="danger" @click="activeEdit = (activeEdit === 'delete' ? null : 'delete')"
                            class="!w-auto !rounded-lg !px-2.5 !py-0.5 !text-xs">
                            Hapus
                        </x-button>
                    </div>
                </div>


                <div x-show="activeEdit === 'profile'" x-cloak>
                    <livewire:admin.classroom.form.edit-classroom :classroomData="$currentClassroomOverview" :key="'edit-classroom-' . $currentClassroomOverview['id']" />
                </div>
            </div>

            {{-- Stats --}}
            <div x-show="!activeEdit" class="mt-4 grid grid-cols-4 gap-3">
                <div class="rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-center">
                    <p class="text-xl font-bold text-gray-800">
                        {{ (int) ($currentClassroomOverview['total_students'] ?? 0) }}</p>
                    <p class="mt-0.5 text-[11px] text-gray-500">Total siswa</p>
                </div>
                <div class="rounded-xl border border-pink-200 bg-pink-50 px-3 py-2.5 text-center">
                    <p class="text-xl font-bold text-pink-700">
                        {{ (int) ($currentClassroomOverview['female_students'] ?? 0) }}</p>
                    <p class="mt-0.5 text-[11px] text-pink-500">Perempuan</p>
                </div>
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-3 py-2.5 text-center">
                    <p class="text-xl font-bold text-blue-700">
                        {{ (int) ($currentClassroomOverview['male_students'] ?? 0) }}</p>
                    <p class="mt-0.5 text-[11px] text-blue-500">Laki-laki</p>
                </div>
                <div class="rounded-xl border border-warning-200 bg-warning-50 px-3 py-2.5 text-center">
                    <p class="text-xl font-bold text-warning-700">
                        {{ (int) ($currentClassroomOverview['occupancy'] ?? 0) }}%</p>
                    <p class="mt-0.5 text-[11px] text-warning-600">Terisi</p>
                </div>
            </div>

            {{-- Occupancy bar --}}
            <div x-show="!activeEdit" class="mt-4">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Komposisi kelas</span>
                    <span class="font-medium text-gray-700">
                        {{ (int) ($currentClassroomOverview['total_students'] ?? 0) }}/{{ (int) ($currentClassroomOverview['capacity'] ?? 0) }}
                        &middot;
                        {{ max((int) ($currentClassroomOverview['capacity'] ?? 0) - (int) ($currentClassroomOverview['total_students'] ?? 0), 0) }}
                        kursi tersisa
                    </span>
                </div>
                <div class="mt-1.5 h-2 overflow-hidden rounded-full bg-gray-100">
                    <div class="h-full rounded-full bg-warning-500 transition-all"
                        style="width: {{ max(0, min((int) ($currentClassroomOverview['occupancy'] ?? 0), 100)) }}%">
                    </div>
                </div>
            </div>

            {{-- Delete confirmation --}}
            <div x-show="activeEdit === 'delete'" x-cloak class="mt-4">
                <livewire:admin.classroom.form.delete-classroom :classroom="$currentClassroomOverview" :key="'delete-classroom-' . $currentClassroomOverview['id']" />
            </div>

        </div>
    </div>
</div>
