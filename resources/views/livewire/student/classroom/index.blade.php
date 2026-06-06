<div>
    <x-header>Data Kelas</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

        {{-- Info Kelas --}}
        <x-card class=" border border-gray-300 border-b-4">
            <div class=" flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-info-icon lucide-info text-secondary-200">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 16v-4" />
                    <path d="M12 8h.01" />
                </svg>
                <p class="text-md font-bold text-secondary-400 mb-3">
                    Info Kelas
                </p>
            </div>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-secondary-100 border-2 border-secondary-900 flex items-center justify-center font-semibold text-lg text-secondary-800 shrink-0"
                    style="box-shadow: 2px 2px 0 #3C3489">
                    {{ $classroom['grade'] }}
                </div>
                <div>
                    <p class="font-semibold text-base text-gray-800">Kelas {{ $classroom['name'] }}</p>
                    <p class="text-xs text-gray-400">T.A. 2025/2026</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-3 space-y-2 text-sm mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-400">Wali Kelas</span>
                    <span class="font-medium text-gray-700">
                        {{ $classroom['homeroom_teacher']['name'] ?? 'Belum Ditentukan' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-center"
                    style="box-shadow: 2px 2px 0 #D1D5DB">
                    <p class="text-xl font-semibold text-secondary-700">{{ count($students) }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total Siswa</p>
                </div>
                <div class="bg-pink-50 border border-pink-200 rounded-lg p-3 text-center"
                    style="box-shadow: 2px 2px 0 #F9A8D4">
                    <p class="text-xl font-semibold text-pink-700">
                        {{ collect($students)->where('gender', 'Perempuan')->count() }}
                    </p>
                    <p class="text-xs text-pink-400 mt-0.5">Perempuan</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center"
                    style="box-shadow: 2px 2px 0 #93C5FD">
                    <p class="text-xl font-semibold text-blue-700">
                        {{ collect($students)->where('gender', 'Laki-Laki')->count() }}
                    </p>
                    <p class="text-xs text-blue-400 mt-0.5">Laki-laki</p>
                </div>
            </div>
        </x-card>

        {{-- Daftar Guru --}}
        <x-card class="border border-gray-300 border-b-4">
            <div class=" flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-users-round-icon lucide-users-round text-secondary-200">
                    <path d="M18 21a8 8 0 0 0-16 0" />
                    <circle cx="10" cy="8" r="5" />
                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                </svg>
                <p class="text-md font-bold text-secondary-400 mb-3">
                    Daftar Guru
                </p>
            </div>


            <div class="space-y-4">
                @foreach ($teachings as $teaching)
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-secondary-100 border border-secondary-300 flex items-center justify-center text-xs font-semibold text-secondary-700 shrink-0 mt-0.5">
                                {{ strtoupper(substr($teaching['teacher']['name'], 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-700">{{ $teaching['teacher']['name'] }}</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @if (empty($teaching['schedules']))
                                        <span
                                            class="text-xs bg-gray-100 text-gray-400 border border-gray-200 rounded-full px-2 py-0.5">
                                            Jadwal belum ditentukan
                                        </span>
                                    @else
                                        @foreach ($teaching['schedules'] as $schedule)
                                            <span
                                                class="text-xs bg-secondary-50 text-secondary-700 border border-secondary-200 rounded-full px-2 py-0.5">
                                                {{ $schedule['code'] }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span
                            class="text-xs bg-secondary-50 text-secondary-700 border border-secondary-200 rounded-full px-3 py-1 shrink-0">
                            {{ $teaching['course']['name'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </x-card>

    </div>

    {{-- Daftar Siswa --}}

    <p class="text-md font-bold text-secondary-400 mb-3">Daftar Siswa</p>



    <div class="overflow-x-auto">
        <div class="overflow-x-auto rounded-lg border border-gray-200" style="box-shadow: 3px 3px 0 #D1D5DB">
            <table class="w-full text-sm">
                <thead>
                    <tr class=" bg-secondary-400/80 border-b-2 border-b-secondary-400">
                        <th class="text-left text-sm font-semibold text-secondary-50 px-4 py-3 w-12">No</th>
                        <th class="text-left text-sm font-semibold text-secondary-50 px-4 py-3">Nama Siswa</th>
                        <th class="text-left text-sm font-semibold text-secondary-50 px-4 py-3">NIS</th>
                        <th class="text-left text-sm font-semibold text-secondary-50 px-4 py-3">L/P</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr
                            class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} hover:bg-gray-300 transition-colors">
                            <td class="px-4 py-2.5 text-gray-400 text-xs border-b border-gray-100">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-2.5 text-gray-700 border-b border-gray-100">
                                {{ $student['name'] ?? 'Tidak Ada Data' }}
                            </td>
                            <td class="px-4 py-2.5 text-gray-400 text-xs font-mono border-b border-gray-100">
                                {{ $student['nis'] ?? '-' }}
                            </td>
                            <td class="px-4 py-2.5 border-b border-gray-100">
                                @if (($student['gender'] ?? null) === 'Laki-Laki')
                                    <span
                                        class="text-xs bg-blue-50 text-blue-700 border border-blue-200 rounded-full px-2.5 py-0.5">L</span>
                                @elseif (($student['gender'] ?? null) === 'Perempuan')
                                    <span
                                        class="text-xs bg-pink-50 text-pink-700 border border-pink-200 rounded-full px-2.5 py-0.5">P</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


</div>
