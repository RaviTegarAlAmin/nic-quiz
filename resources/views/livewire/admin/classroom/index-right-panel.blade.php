<div class="flex-1 flex flex-col gap-3 overflow-hidden min-h-0">

    <div x-data="{ activeEdit: null,selected: @entangle('selectedClassroomId') }"
    x-effect="selected; activeEdit = null"
    x-on:keyup.escape.window="activeEdit = null" class="contents">

        {{-- Empty State --}}
        @if (!$selectedClassroomId)
            <x-card class="flex-1 flex flex-col items-center justify-center gap-3">
                <div
                    class="w-14 h-14 rounded-full bg-secondary-50 border border-secondary-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-secondary-400">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M9 21V9" />
                    </svg>
                </div>

                <p class="text-sm font-medium text-gray-700">
                    Pilih kelas untuk melihat detail
                </p>

                <p class="text-xs text-gray-400">
                    Klik salah satu kelas di sebelah kiri
                </p>
            </x-card>
        @else
            {{-- Header --}}
            <x-ui.detail-card
                class="relative overflow-hidden flex items-center justify-between gap-3 border-l-4 border-warning-600 !bg-warning-600/70 font-bold text-gray-600 !text-sm flex-shrink-0 !px-4 !py-3">

                <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-white opacity-20"></div>

                <span class="relative z-10">
                    Kelas {{ $currentClassroomOverview['name'] ?? '-' }}
                </span>

            </x-ui.detail-card>

            {{-- Main Content --}}
            <x-card class="flex-1 flex flex-col overflow-hidden !p-0 !shadow-lg">

                {{-- Tabs --}}
                <div class="flex border-b border-gray-100 flex-shrink-0">

                    <button wire:click="selectTab('overview')" @click="activeEdit = null"
                        class="px-5 py-3 text-xs font-medium transition-colors
                            {{ $activeTab === 'overview'
                                ? 'text-secondary-600 border-b-2 border-secondary-500'
                                : 'text-gray-400 hover:text-gray-600' }}">
                        Overview
                    </button>

                    <button wire:click="selectTab('teachings')" @click="activeEdit = null"
                        class="px-5 py-3 text-xs font-medium transition-colors
                            {{ $activeTab === 'teachings'
                                ? 'text-secondary-600 border-b-2 border-secondary-500'
                                : 'text-gray-400 hover:text-gray-600' }}">
                        Pengajaran
                    </button>

                    <button wire:click="selectTab('schedules')" @click="activeEdit = null"
                        class="px-5 py-3 text-xs font-medium transition-colors
                            {{ $activeTab === 'schedules'
                                ? 'text-secondary-600 border-b-2 border-secondary-500'
                                : 'text-gray-400 hover:text-gray-600' }}">
                        Jadwal
                    </button>

                    <button wire:click="selectTab('students')" @click="activeEdit = null"
                        class="px-5 py-3 text-xs font-medium transition-colors
                            {{ $activeTab === 'students'
                                ? 'text-secondary-600 border-b-2 border-secondary-500'
                                : 'text-gray-400 hover:text-gray-600' }}">
                        Siswa
                    </button>

                </div>

                {{-- Loading --}}
                <div wire:loading.flex class="flex-1 items-center justify-center">
                    <div class="text-sm text-gray-400">
                        Memuat data...
                    </div>
                </div>

                {{-- Tab Content --}}
                <div wire:loading.remove class="flex-1 overflow-y-auto">

                    @switch($activeTab)
                        @case('overview')
                            @include('livewire.admin.classroom.tabs.overview')
                        @break

                        @case('teachings')
                            @include('livewire.admin.classroom.tabs.teachings')
                        @break

                        @case('schedules')
                            @include('livewire.admin.classroom.tabs.schedules')
                        @break

                        @case('students')
                            @include('livewire.admin.classroom.tabs.students')
                        @break
                    @endswitch

                </div>

            </x-card>
        @endif

    </div>

</div>
