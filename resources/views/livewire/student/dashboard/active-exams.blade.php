<div class=" h-full mt-2">

    <x-ui.detail-card
        class="relative border-gray-400/80 border-l-4 bg-warning-600/70 hover:shadow-sm overflow-hidden mb-3">

        <div class=" flex justify-start gap-2">
            <div class=" -mt-2 mx-auto">
                <h6 class=" text-lg text-gray-600 font-bold">
                    Ujian Aktif
                </h6>
            </div>
        </div>
        <div class="absolute -left-20 -top-4 bg-white border-2 border-success-300 w-36 h-36 rounded-full opacity-30">
            &nbsp;
        </div>
    </x-ui.detail-card>

    <x-card class=" h-full border-l-4 border-b-8 border-gray-400 overflow-y-auto overflow-x-hidden ">
        {{-- Ongoing Exams --}}
        <h2 class=" -mt-4 -ml-1  mb-2 text-danger-400 font-extrabold">
            Ujian Berlangsung
        </h2>

        @if ($ongoing || !$onhold)

            @foreach ($ongoing as $exam)
                <div class=" flex justify-between mb-2 cursor-default" wire:key="{{ $exam['assignment_id'] }}">
                    {{-- Ongoing Exam Details --}}
                    <div class=" flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-circle-dot text-danger-600 [animation:pulse_2s_ease-in-out_10]">
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="12" cy="12" r="1" />
                        </svg>

                        <div>
                            @if (!isset($exam['title']))
                                <p>
                                    Tidak Ada Data
                                </p>
                            @else
                                <p class=" [animation:pulse_2s_ease-in-out_10]">
                                    {{ Str::length($exam['title']) > 15 ? substr($exam['title'], 0, 15) . '...' : $exam['title'] }}
                                </p>
                            @endif

                            <p class=" text-xs text-gray-400">
                                Berakhir:
                                {{ \Carbon\Carbon::parse($exam['end_at'])->diffForHumans() ?? 'Tidak Ada Data' }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('student.exams.start', ['assignment' => $exam['assignment_id']]) }}"
                            method="POST">
                            <x-button variant="outline" type="button" class=" !w-24 mr-3">
                                Lanjutkan
                            </x-button>
                        </form>
                    </div>
                </div>
            @endforeach

            @foreach ($onhold as $exam)
                <div class=" flex justify-between mb-2 cursor-default" wire:key="{{ $exam['assignment_id'] }}">
                    {{-- Ongoing Exam Details --}}
                    <div class=" flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-dot text-warning-600 ">
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="12" cy="12" r="1" />
                        </svg>

                        <div>
                            @if (!isset($exam['title']))
                                <p>
                                    Tidak Ada Data
                                </p>
                            @else
                                <p>
                                    {{ Str::length($exam['title']) > 15 ? substr($exam['title'], 0, 15) . '...' : $exam['title'] }}
                                </p>
                            @endif

                            <p class=" text-xs text-gray-400">
                                Berakhir:
                                {{ \Carbon\Carbon::parse($exam['end_at'])->diffForHumans() ?? 'Tidak Ada Data' }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button" disabled
                            class="w-24 mr-3 cursor-pointer text-center text-gray-500  bg-gray-300 border border-gray-500  font-semibold rounded-xl px-3 py-1 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Ditunda
                        </button>
                    </div>
                </div>
            @endforeach
            <hr class="h-px mb-2 bg-gray-400 border-0">
        @else
            <p class=" text-xl text-gray-300 text-center mb-3">
                Tidak Ada Ujian Berlangsung
            </p>
        @endif

        <h2 class=" -mt-1 -ml-1  mb-2 text-secondary-400 font-extrabold">
            Ujian Akan Datang
        </h2>
        @if ($upcoming)

            @foreach ($upcoming as $exam)
                <div class="flex justify-between mb-2 cursor-default" wire:key="{{ $exam['assignment_id'] }}">

                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-circle-dot text-secondary-400">
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="12" cy="12" r="1" />
                        </svg>

                        <div>
                            @if (!isset($exam['title']))
                                <p>Tidak Ada Data</p>
                            @else
                                <p>{{ Str::length($exam['title']) > 15 ? substr($exam['title'], 0, 15) . '...' : $exam['title'] }}
                                </p>
                            @endif

                            <p class="text-xs text-gray-400">
                                Mulai:
                                {{ \Carbon\Carbon::parse($exam['start_at'])->diffForHumans() ?? 'Tidak Ada Data' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-1 min-w-32 -mr-5">
                        <div class="flex gap-1">
                            <div
                                class="text-white border-2 border-warning-500 hover:border-warning-600 rounded-xl w-12 py-1 text-center text-xs bg-warning-600 hover:bg-warning-500 font-bold">
                                {{ $exam['code'] ?? 'N/A' }}
                            </div>
                            <div
                                class="text-white border-2 border-gray-300 hover:border-gray-500 hover:bg-gray-400 rounded-xl w-10 py-1 text-center text-xs bg-gray-400/60 font-semibold">
                                {{ $exam['duration'] ?? 'N/A' }}
                            </div>
                        </div>
                        <p class="text-xs text-gray-400">
                            @if (!isset($exam['teacher']))
                                Tidak Ada Data
                            @else
                                {{ Str::length($exam['teacher']) > 15 ? substr($exam['teacher'], 0, 15) . '...' : $exam['teacher'] }}
                            @endif
                        </p>
                    </div>

                </div>
            @endforeach
            <hr class="h-px mb-2 bg-gray-400 border-0">
        @else
            <p class=" text-xl text-gray-300 text-center">
                Tidak Ada Ujian Akan Datang
            </p>
        @endif

    </x-card>
</div>
