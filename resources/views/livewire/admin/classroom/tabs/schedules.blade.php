<div class="p-5">

    @php
        $schedules = $currentClassroomSchedules;
    @endphp

    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">
            Jadwal
        </p>
        <p class="mt-1 text-sm text-gray-500">
            Jadwal pelajaran mingguan
        </p>
    </div>

    {{-- Empty state --}}
    @if (empty($schedules))
        <div
            class="mt-6 flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 py-10 text-center">
            <p class="text-sm font-medium text-gray-600">
                Belum ada jadwal terhubung
            </p>
            <p class="text-xs text-gray-400">
                Jadwal pelajaran belum diatur untuk kelas ini
            </p>
        </div>
    @else
        {{-- Days as columns --}}
        <div class="mt-4 flex gap-3 overflow-x-auto pb-2">
            @foreach ($schedules as $day => $periods)
                <div wire:key="day-{{ $day }}" class="flex w-20 flex-shrink-0 flex-col gap-1.5">

                    <p class="px-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                        {{ $day }}
                    </p>

                    @if (empty($periods))
                        <div
                            class="rounded-lg border border-dashed border-gray-200 px-2 py-3 text-center text-[11px] text-gray-400">
                            Tidak ada jadwal
                        </div>
                    @else
                        <div class="flex flex-col gap-1.5">

                            @foreach ($periods as $periodCode => $period)
                                @if (empty($period['schedule_id']))
                                    <div wire:key="period-{{ $periodCode }}"
                                        class="rounded-lg border border-dashed border-gray-200 px-2 py-2 text-center text-[11px] text-gray-400">
                                        Kosong
                                    </div>
                                @else
                                    <div wire:key="period-{{ $period['schedule_id'] }}" x-data="{ hovered: false }"
                                        @mouseenter="hovered = true" @mouseleave="hovered = false"
                                        class="rounded-lg border border-gray-200 bg-white px-2 py-2 transition-colors hover:border-secondary-200 hover:bg-secondary-50">
                                        <p class="truncate text-xs font-semibold text-gray-800">
                                            {{ $period['course_code'] }}
                                        </p>
                                        <p class="mt-0.5 truncate text-[11px] text-gray-500">
                                            {{ \App\Support\StringFormatter\NameFormatter::shortenName($period['teacher']) }}
                                        </p>

                                        <div x-show="hovered" x-transition:enter="transition ease-out duration-150"
                                            x-transition:enter-start="opacity-0 -translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="mt-1.5 flex items-center justify-between border-t border-gray-100 pt-1.5 text-[10px] text-gray-500"
                                            style="display: none;">
                                            <span>
                                                Awal
                                                <span class="font-semibold text-gray-700">
                                                    {{ \Carbon\Carbon::parse($period['start_at'])->format('H:i') }}
                                                </span>
                                            </span>
                                            <span>
                                                Akhir
                                                <span class="font-semibold text-gray-700">
                                                    {{ \Carbon\Carbon::parse($period['start_at'])->addMinutes($period['duration'])->format('H:i') }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @endif

</div>
