<div class="p-5">

    @php
        $teachings = $currentClassroomTeachings
    @endphp

    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">
            Pengajaran
        </p>
        <p class="mt-1 text-sm text-gray-500">
            {{ count($teachings ?? []) }} mata pelajaran diampu di kelas ini
        </p>
    </div>

    {{-- Empty state --}}
    @if (empty($teachings))
        <div
            class="mt-6 flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 py-10 text-center">
            <p class="text-sm font-medium text-gray-600">
                Belum ada pengajaran terhubung
            </p>
            <p class="text-xs text-gray-400">
                Mata pelajaran dan guru pengampu belum diatur untuk kelas ini
            </p>
        </div>
    @else
        {{-- List --}}
        <div class="mt-4 grid grid-cols-1 gap-2.5 md:grid-cols-2">
            @foreach ($teachings as $teaching)
                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3">

                    <span
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg border border-secondary-200 bg-secondary-50 text-xs font-bold text-secondary-700">
                        {{ $teaching['course_code'] }}
                    </span>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-gray-800">
                            {{ $teaching['course_name'] }}
                        </p>
                        <p class="mt-0.5 truncate text-xs text-gray-500">
                            {{ $teaching['teacher_name'] }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
