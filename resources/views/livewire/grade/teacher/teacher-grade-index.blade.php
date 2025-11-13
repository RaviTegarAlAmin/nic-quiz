<div>
    <x-header class=" mb-4 bg-secondary-400 text-white border-r-4 border-secondary-300 rounded-md">
        Penilaian {{ $exam->title }}
    </x-header>

    <x-tag class=" md:w-32 text-center mb-4">
        Penugasan
    </x-tag>

    {{-- Assignment Card List --}}
    <div class=" md:flex md:justify-between md:gap-3 gap-5 w-full mx-auto px-0">
        <div
            class=" grid grid-flow-col grid-rows-2 gap-3 overflow-x-auto md:w-2/3 w-full py-4 border  border-secondary-400 px-4 rounded-md border-b-4 border-r-8 bg-gray-100/80 ">
            @foreach ($examAssignments as $assignment)
                <x-card @class([
                    ' w-64 cursor-pointer hover:shadow-xl border-2 border-l-4 border-gray-100 border-r-gray-200 hover:border-secondary-400 hover:rotate-1 transition-all ease-in-out',
                    'bg-secondary-400' =>
                        $currentAssignment != null && $currentAssignment->id == $assignment->id,
                ]) wire:key="assignment-{{ $assignment->id }}"
                    wire:click="changeCurrentAssignment({{ $assignment->id }})">
                    <div class=" flex justify-between mb-4">
                        <x-class-status-tag class=" !text-secondary-400">
                            {{ $assignment->examTakers->first()?->student?->classroom?->name }}
                        </x-class-status-tag>
                        <x-tag>
                            {{ $assignment->duration }}
                        </x-tag>
                    </div>
                    <p>
                        {{ 'Mulai     : ' . date_format($assignment->start_at, 'd M Y') }}
                    </p>
                    <p>
                        {{ 'Berakhir : ' . date_format($assignment->end_at, 'd M Y') }}
                    </p>
                </x-card>
            @endforeach
        </div>

        {{-- Assignment Info --}}
        <x-card class=" md:w-1/3 w-full border border-b-4 border-secondary-400 border-r-8">
            <h2 class=" font-bold text-secondary-400 mb-4">Info Penugasan</h2>
            <hr class=" border border-secondary-300 w-full mx-auto">
            @if ($currentAssignment != null)
                <div class=" font-semibold" wire:loading.remove>
                    <div></div>
                    <p class=" m-2">Peserta Ujian {{ $currentAssignment->examTakers->count() }}</p>
                    <p class=" m-2"> Waktu Mulai: {{ $currentAssignment->start_at }} </p>
                </div>
                <div class="flex items-center justify-center h-32" wire:loading>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                        class="size-7 fill-primary motion-safe:animate-spin dark:fill-primary-dark">
                        <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                            opacity=".25" />
                        <path
                            d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                    </svg>
                </div>
            @else
                <div class=" py-14 text-center text-gray-400 text-lg">
                    Pilih penugasan untuk melihat info
                </div>
            @endif

        </x-card>
    </div>

    {{-- Exam Taker Data Table For Teacher Grade --}}

    @if ($currentAssignment)
        <div class=" flex justify-between align-middle">
            <x-tag class="w-32 mt-5">Peserta Ujian</x-tag>
            <x-button wire:click="correction({{ $currentAssignment }})" variant="success"
                class="mt-5 transition-opacity duration-200" wire:loading.class="opacity-50 cursor-not-allowed"
                wire:target="correction">
                <span wire:loading.remove wire:target="correction">Nilai Ujian</span>
                <span wire:loading wire:target="correction">Loading...</span>
            </x-button>
        </div>
        <div class="md:overflow-x-visible overflow-x-auto">
            <div wire:loading
                class=" w-full min-h-28 bg-gray-100 animate-pulse border border-slate-100 drop-shadow-md rounded-md mt-5 flex justify-center items-center">
                <p class=" text-center font-bold text-secondary-400 opacity-50 align-middle">Memuat Tabel...</p>
            </div>
            <table
                class="table w-full border-separate border-spacing-0 drop-shadow-lg text-center rounded-lg overflow-hidden mt-10 border-r-8 border-r-secondary-500/60"
                wire:loading.remove>
                <thead class="bg-secondary-400 text-white px-4 py-6 font-semibold text-center">
                    <tr>
                        <th class="py-6">
                            Nama
                        </th>
                        <th>
                            Mulai
                        </th>
                        <th>
                            Selesai
                        </th>
                        <th>
                            Soal Terisi
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Nilai
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currentAssignment->examTakers as $examTaker)
                        <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-200">

                            {{-- Generic Text Data --}}

                            <td class=" border px-4 py-2 whitespace-nowrap text-left flex justify-between">
                                <a href="" class=" hover:underline hover:text-seondary-400">
                                    {{ $examTaker->student->name }}
                                </a>

                                <div>
                                    <a
                                        href="{{ route('teacher.exams.grade.correction', [$exam, $currentAssignment]) }}?examTakerId={{ $examTaker->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" title="Lihat Hasil Ujian"
                                            class="lucide lucide-move-up-right-icon lucide-move-up-right text-slate-400 hover:text-gray-600 cursor-pointer">
                                            <path d="M13 5H19V11" />
                                            <path d="M19 5L5 19" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ date_format($examTaker->start_at, 'D, d M Y H:i') }}
                            </td>
                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ $examTaker->finished_at ? date_format($examTaker->finished_at, 'D, d M Y H:i') : '-' }}
                            </td>

                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ $examTaker->filledAnswers()->count() }}
                            </td>


                            <td class=" border px-4 py-2 whitespace-nowrap">
                                @if ($examTaker->status == 'ongoing')
                                    <x-class-status-tag status="ongoing" :label="true">
                                    </x-class-status-tag>
                                @else
                                    <x-class-status-tag status="finished" :label="true">
                                    </x-class-status-tag>
                                @endif
                            </td>
                            @if ($examTaker->grade?->exam_score != null)
                                <td class=" border px-4 py-2 whitespace-nowrap">
                                    {{ $examTaker->grade->exam_score }}
                                </td>
                            @else
                                <td class=" px-3">
                                    <x-tag class=" bg-danger-400 border-danger-500 !text-danger-600">
                                        Belum Dinilai
                                    </x-tag>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    @else
        {{-- No Current Assignment --}}
        <div
            class=" border-4 border-slate-100 border-dashed text-center text-slate-300 py-5 hover:border-slate-400/75 hover:text-slate-400/75 mt-8 cursor-pointer">
            Pilih Penugasan
        </div>
    @endif

</div>
