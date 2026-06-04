<div class=" h-full mt-2">

    <x-ui.detail-card
        class="relative border-gray-400/80 border-l-4 bg-warning-600/70 hover:shadow-sm overflow-hidden mb-3">

        <div class=" flex justify-start gap-2">
            <div class=" -mt-2 mx-auto">
                <h6 class=" text-lg text-gray-600 font-bold">
                    Aktivitas Terakhir
                </h6>
            </div>
        </div>
        <div class="absolute -left-20 -top-4 bg-white border-2 border-success-300 w-36 h-36 rounded-full opacity-30">
            &nbsp;
        </div>
    </x-ui.detail-card>

    {{-- Latest Activity --}}

    <x-card class=" border-l-4 border-b-8 border-gray-400 h-full">
        @if ($latestScores != [])
            @foreach ($latestScores as $score)
                <div class="flex justify-between mb-2 cursor-default" wire:key="{{ $score->id }}">

                    <div class="flex gap-2">
                        @if ($score->exam_score === null)
                            {{-- Ungraded --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-clock text-gray-400 shrink-0">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        @else
                            {{-- Graded --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-circle-check-big text-success-400 shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        @endif

                        <div>
                            <p>{{ Str::length($score->title) > 15 ? substr($score->title, 0, 15) . '...' : $score->title }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($score->finished_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-start gap-1 min-w-32 -mr-5">
                        <div class="flex gap-1">
                            @if ($score->exam_score === null)
                                <div
                                    class="text-white border-2 border-gray-300 rounded-xl px-2 py-1 text-center text-xs bg-gray-400/60 font-semibold">
                                    Menunggu
                                </div>
                            @else
                                <div @class([
                                    'text-white border-2 rounded-xl w-14 py-1 text-center text-xs font-bold',
                                    'border-success-500 bg-success-600 hover:bg-success-500' =>
                                        $score->exam_score >= 75,
                                    'border-warning-500 bg-danger-600 hover:bg-danger-500' =>
                                        $score->exam_score >= 60 && $score->exam_score < 75,
                                    'border-danger-500 bg-danger-700 hover:bg-danger-600' =>
                                        $score->exam_score < 60,
                                ])>
                                    {{ number_format($score->exam_score, 1) }}
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400">
                            {{ Str::length($score->name) > 15 ? substr($score->name, 0, 15) . '...' : $score->name }}
                        </p>
                    </div>

                </div>
            @endforeach
        @else
            <p class=" text-xl text-gray-300 text-center">
                Tidak ada data
            </p>
        @endif
    </x-card>

</div>
