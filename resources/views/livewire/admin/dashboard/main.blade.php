<div>
    <x-header>Dashboard Admin</x-header>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="relative overflow-hidden bg-secondary-50 border border-secondary-200 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #AFA9EC">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-secondary-400 opacity-20"></div>
            <p class="text-2xl font-semibold text-secondary-900">{{ $stats['total_students'] }}</p>
            <p class="text-xs text-secondary-600 mt-1">Total Siswa</p>
        </div>
        <div class="relative overflow-hidden bg-teal-50 border border-teal-200 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #5DCAA5">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-teal-400 opacity-20"></div>
            <p class="text-2xl font-semibold text-teal-900">{{ $stats['total_teachers'] }}</p>
            <p class="text-xs text-teal-700 mt-1">Total Guru</p>
        </div>
        <div class="relative overflow-hidden bg-warning-50 border border-warning-200 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #EF9F27">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-warning-400 opacity-20"></div>
            <p class="text-2xl font-semibold text-warning-900">{{ $stats['total_classrooms'] }}</p>
            <p class="text-xs text-warning-700 mt-1">Total Kelas</p>
        </div>
        <div class="relative overflow-hidden bg-danger-50 border border-danger-200 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #F0997B">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-danger-400 opacity-20"></div>
            <p class="text-2xl font-semibold text-danger-900">{{ $stats['total_courses'] }}</p>
            <p class="text-xs text-danger-700 mt-1">Total Mata Pelajaran</p>
        </div>
    </div>

    {{-- Daftar Kelas --}}
    <x-ui.detail-card
        class="relative overflow-hidden flex items-center gap-2 border-l-4 border-warning-600 !bg-warning-600/70 font-bold text-gray-600 !text-base mb-2">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-white opacity-20"></div>
        Daftar Kelas
    </x-ui.detail-card>
    <x-card class="mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background-color: #7C6FD4; border-bottom: 2px solid #3C3489;">
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Kelas</th>
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Tingkat</th>
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Wali Kelas</th>
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Siswa</th>
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Kapasitas</th>
                        <th class="text-left text-xs font-semibold text-secondary-50 px-4 py-3">Isi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classrooms as $index => $classroom)
                        @php
                            $pct = (int) $classroom['occupation'];
                            $gradeColor = match ($classroom['grade']) {
                                '9' => 'bg-secondary-50 text-secondary-700 border-secondary-200',
                                '8' => 'bg-warning-50 text-warning-700 border-warning-200',
                                default => 'bg-danger-50 text-danger-700 border-danger-200',
                            };
                            $pctColor = match (true) {
                                $pct >= 80 => 'bg-success-50 text-success-700 border-success-200',
                                $pct >= 50 => 'bg-warning-50 text-warning-700 border-warning-200',
                                default => 'bg-danger-50 text-danger-700 border-danger-200',
                            };
                        @endphp
                        <tr
                            class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-secondary-50/30' }} hover:bg-secondary-50 transition-colors">
                            <td class="px-4 py-2.5 font-medium text-gray-700 border-b border-gray-100">
                                {{ $classroom['name'] }}</td>
                            <td class="px-4 py-2.5 border-b border-gray-100">
                                <span class="text-xs rounded-full px-2.5 py-0.5 border font-medium {{ $gradeColor }}">
                                    {{ $classroom['grade'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 border-b border-gray-100">
                                @if ($classroom['homeroom_teacher'])
                                    <span class="text-gray-700">{{ $classroom['homeroom_teacher'] }}</span>
                                @else
                                    <span class="text-xs text-danger-500 italic">Belum Ditentukan</span>
                                @endif
                            </td>
                            <td class="px-4 py-2.5 text-gray-700 border-b border-gray-100">
                                {{ $classroom['total_students'] }}</td>
                            <td class="px-4 py-2.5 text-gray-400 border-b border-gray-100">{{ $classroom['capacity'] }}
                            </td>
                            <td class="px-4 py-2.5 border-b border-gray-100">
                                <span
                                    class="text-xs rounded-full px-2.5 py-0.5 border font-medium {{ $pctColor }}">
                                    {{ $pct }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Jadwal Pelajaran --}}
    <x-ui.detail-card
        class="relative overflow-hidden flex items-center gap-2 border-l-4 border-warning-600 !bg-warning-600/70 font-bold text-gray-600 !text-base mb-2">
        <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-white opacity-20"></div>
        Jadwal Pelajaran
    </x-ui.detail-card>

    @if (!empty($schedules))
        <div x-data="{
            activeGrade: {{ array_key_first($schedules) }},
            activeClass: '{{ array_key_first(array_values($schedules)[0]) }}'
        }">
            <x-card>

                {{-- Grade Tabs --}}
                <div class="flex gap-2 mb-4">
                    @foreach ($schedules as $grade => $classrooms)
                        <button
                            x-on:click="activeGrade = '{{ $grade }}'; activeClass = '{{ !empty($classrooms) ? array_key_first($classrooms) : '' }}'"
                            :class="activeGrade == '{{ $grade }}' ?
                                'bg-secondary-400 border-secondary-500 text-secondary-50' :
                                'bg-white border-secondary-200 text-secondary-600 hover:bg-secondary-50'"
                            class="px-4 py-1.5 rounded-lg border-2 text-xs font-semibold transition-all"
                            :style="activeGrade == '{{ $grade }}' ? 'box-shadow: 2px 2px 0 #3C3489' : ''">
                            Kelas {{ $grade }}
                        </button>
                    @endforeach
                </div>

                {{-- Class Slides per Grade --}}
                @foreach ($schedules as $grade => $classrooms)
                    <div x-cloak x-show="activeGrade == '{{ $grade }}'" class="flex items-center gap-2 mb-5">
                        <button
                            class="w-7 h-7 rounded-lg border-2 border-secondary-200 bg-white flex items-center justify-center text-secondary-500 text-xs hover:bg-secondary-50">&#8592;</button>

                        <div class="flex gap-2">
                            @foreach ($classrooms as $className => $days)
                                <span x-on:click="activeClass = '{{ $className }}'"
                                    :class="activeClass === '{{ $className }}' ?
                                        'bg-secondary-50 border-secondary-500 text-secondary-700' :
                                        'bg-white border-secondary-200 text-secondary-500'"
                                    class="text-xs px-3 py-1 rounded-full border-2 font-medium cursor-pointer">
                                    {{ $className }}
                                </span>
                            @endforeach
                        </div>

                        <button
                            class="w-7 h-7 rounded-lg border-2 border-secondary-200 bg-white flex items-center justify-center text-secondary-500 text-xs hover:bg-secondary-50">&#8594;</button>
                    </div>
                @endforeach

                {{-- Timeline --}}
                @foreach ($schedules as $grade => $classrooms)
                    <div x-cloak x-show="activeGrade == '{{ $grade }}'">
                        @foreach ($classrooms as $className => $days)
                            <div x-cloak x-show="activeClass === '{{ $className }}'" class="space-y-3">
                                @foreach ($days as $day => $periods)
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="text-xs font-medium text-gray-500 w-12 text-right shrink-0">{{ $day }}</span>

                                        <div class="flex gap-2 flex-wrap">
                                            @foreach ($periods as $code => $period)
                                                @if ($period['course'] === null)
                                                    <div
                                                        class="border rounded-lg px-2.5 py-1.5 text-xs bg-gray-50 text-gray-800 border-gray-200">
                                                        <p class="font-medium">
                                                            {{ $period['type'] == 'lecture' ? 'TBD' : 'Istirahat' }}
                                                        </p>
                                                        <p class="text-xs opacity-70">
                                                            {{ \Carbon\Carbon::parse($period['start_at'])->format('H.i') }}
                                                        </p>
                                                    </div>
                                                @else
                                                    @php
                                                        $colors = [
                                                            'MTK' =>
                                                                'bg-secondary-50 text-secondary-800 border-secondary-200',
                                                            'IPA' => 'bg-teal-50 text-teal-800 border-teal-200',
                                                            'IPS' => 'bg-danger-50 text-danger-800 border-danger-200',
                                                            'IND' =>
                                                                'bg-warning-50 text-warning-800 border-warning-200',
                                                            'ENG' => 'bg-pink-50 text-pink-800 border-pink-200',
                                                            'PKN' => 'bg-green-50 text-green-800 border-green-200',
                                                        ];
                                                        $color =
                                                            $colors[$period['course_code']] ??
                                                            'bg-gray-50 text-gray-800 border-gray-200';
                                                        $startTime = \Carbon\Carbon::parse($period['start_at'])->format(
                                                            'H.i',
                                                        );
                                                        $endTime = \Carbon\Carbon::parse($period['start_at'])
                                                            ->addMinutes($period['duration'])
                                                            ->format('H.i');
                                                    @endphp
                                                    <div
                                                        class="border rounded-lg px-2.5 py-1.5 text-xs {{ $color }}">
                                                        <p class="font-medium">{{ $period['course_code'] }}</p>
                                                        <p class="text-xs opacity-70">
                                                            {{ $startTime }}–{{ $endTime }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </x-card>
        </div>
    @else
        <x-card>
            <p class="text-sm text-gray-400 text-center py-4">Memuat jadwal...</p>
        </x-card>
    @endif



</div>
