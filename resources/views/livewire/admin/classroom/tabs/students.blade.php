<div class="p-5">

    @php
        $students = $currentClassroomStudents;
    @endphp

    {{-- Header --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-gray-400">
            Siswa
        </p>
        <p class="mt-1 text-sm text-gray-500">
            {{ count($students ?? []) }} siswa terdaftar di kelas ini
        </p>
    </div>

    {{-- Empty state --}}
    @if (empty($students))
        <div
            class="mt-6 flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 py-10 text-center">
            <p class="text-sm font-medium text-gray-600">
                Belum ada siswa terdaftar
            </p>
            <p class="text-xs text-gray-400">
                Siswa belum ditempatkan di kelas ini
            </p>
        </div>
    @else
        <div class="mt-4 overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            No</th>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            Nama</th>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            NIS</th>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            L/P</th>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            Tgl Lahir</th>
                        <th
                            class="px-3 py-2.5 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-400">
                            Alamat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($students as $index => $student)
                        <tr wire:key="student-{{ $student['id'] }}" class="hover:bg-gray-50">
                            <td class="px-3 py-2.5 text-gray-400">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-3 py-2.5 font-medium text-gray-800">
                                {{ $student['name'] }}
                            </td>
                            <td class="px-3 py-2.5 text-gray-500">
                                {{ $student['nis'] }}
                            </td>
                            <td class="px-3 py-2.5">
                                @if ($student['gender'] === 'Laki-Laki')
                                    <span
                                        class="rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-[11px] font-medium text-blue-700">
                                        L
                                    </span>
                                @else
                                    <span
                                        class="rounded-full border border-pink-200 bg-pink-50 px-2 py-0.5 text-[11px] font-medium text-pink-700">
                                        P
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2.5 whitespace-nowrap text-gray-500">
                                {{ \Carbon\Carbon::parse($student['born_date'])->translatedFormat('d M Y') }}
                            </td>
                            <td class="max-w-[220px] truncate px-3 py-2.5 text-gray-500"
                                title="{{ $student['address'] }}">
                                {{ Str::of($student['address'])->squish() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
