<div>
    {{-- Header --}}
    <x-slot name="header">
        <div class=" flex justify-between items-center mx-auto">
            <x-header class=" text-white">{{ $exam['title'] }}</x-header>
            <x-profile></x-profile>

        </div>
    </x-slot>


    <div class=" grid md:grid-cols-4 grid-cols-1 md:gap-4 gap-1">
        <div class=" col-span-3">
            {{-- Question field --}}
            <x-card class="  mb-4 text-slate-600">

                <div class=" flex justify-between">
                    <x-tag class=" mb-4"> Pertanyaan {{ $currentIndex + 1 }}</x-tag>
                    <div class=" -mt-5">
                        @if (($markedQuestions[$question['id']] ?? false) === true || $marked)
                            <div wire:click="toggleMarkedAnswer" id="marked" title="Unmark Question">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="lucide lucide-bookmark w-10 h-10 text-warning-600 hover:text-secondary-400/75 hover:cursor-pointer"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                </svg>
                            </div>
                        @else
                            <div wire:click="toggleMarkedAnswer" id="not_marked" title="Mark Question">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="lucide lucide-bookmark w-10 h-10 text-secondary-400 hover:text-warning-600 hover:cursor-pointer"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                </svg>
                            </div>
                        @endif

                    </div>
                </div>

                <hr class=" border-slate-300 border rounded-md mb-3">
                <div class=" h-30 max-h-64 overflow-y-auto text-lg mb-2">
                    {{ $question['question'] }}
                </div>
                <p class=" text-end text-slate-400 hover:text-slate-600  cursor-default">
                    {{ $answeredQuestions }} Dari {{ $totalQuestions }} Soal Terjawab
                </p>
            </x-card>

            {{-- Answer Field --}}

            <x-card class=" mb-4">

                {{-- Multiple Choice --}}
                @if ($question['type'] == 'multiple_choice')
                    <div class=" grid grid-cols-1 md:grid-cols-2 w-full md:gap-2 gap-1">
                        @foreach ($question['options'] as $index => $option)
                            <div x-data="{ checkHover: false }" class=" relative group">
                                <div @class([
                                    'w-full h-full min-h-14 border border-primary-100 ring-1 ring-slate-300 focus:border-primary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-md text-sm font-normal py-1 pr-10 pl-2 cursor-pointer',
                                    'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border hover:bg-danger-500 hover:border-b-danger-600 hover:border-r-danger-600 border-t-danger-300' =>
                                        $currentAnswer == $option['label'],
                                ])
                                    wire:key="option-{{ $question['id'] }}-{{ $index }}"
                                    wire:click="toggleCorrectAnswer({{ $option['label'] }})"
                                    x-on:mouseover="checkHover= !checkHover" x-on:mouseout="checkHover = !checkHover"
                                    x-bind:class="checkHover
                                        ?
                                        'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border' :
                                        ''">
                                    {{ $option['option'] }}
                                </div>

                                @if ($currentAnswer == $option['label'])
                                    <div class=" absolute top-2 right-2 text-white"
                                        x-on:mouseover="checkHover= !checkHover"
                                        x-on:mouseout="checkHover = !checkHover"
                                        wire:click="toggleCorrectAnswer({{ $option['label'] }})"
                                        x-bind:class="checkHover ? ' text-white' : ''">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-check-big-icon lucide-square-check-big cursor-pointer">
                                            <path
                                                d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                            <path d="m9 11 3 3L22 4" />
                                        </svg>

                                    </div>
                                @else
                                    <div class=" absolute top-2 right-2 text-secondary-400"
                                        x-on:mouseover="checkHover= !checkHover"
                                        x-on:mouseout="checkHover = !checkHover"
                                        wire:click="toggleCorrectAnswer({{ $option['label'] }})"
                                        x-bind:class="checkHover ? ' text-white' : ''">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-square-icon lucide-square cursor-pointer">
                                            <rect width="18" height="18" x="3" y="3" rx="2" />
                                        </svg>

                                    </div>
                                @endif


                            </div>
                        @endforeach

                    </div>
                @else
                    {{-- Essay --}}

                    <div>
                        <x-form-input wire:model.live.debounce.200ms="currentAnswer" type="textarea" col="30"
                            row="4"></x-form-input>
                    </div>
                @endif

            </x-card>

            {{-- Navigation Button --}}


            <div class="flex justify-between col-span-3">
                <!-- Previous -->
                <button wire:click="changeIndex({{ $currentIndex - 1 }})" @disabled($currentIndex == 0)
                    @class([
                        'py-1 px-5 text-secondary-400 hover:underline',
                        'text-slate-400' => $currentIndex == 0,
                    ])>
                    <div class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-arrow-big-left-dash-icon lucide-arrow-big-left-dash pt-1">
                            <path
                                d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z" />
                            <path d="M20 9v6" />
                        </svg>
                        <p>Previous</p>
                    </div>
                </button>

                <!-- Next -->
                <button wire:click="changeIndex({{ $currentIndex + 1 }})" @disabled($currentIndex == count($exam['questions']) - 1)
                    @class([
                        'py-1 px-5 text-secondary-400 hover:underline',
                        'text-slate-400' => $currentIndex == count($exam['questions']) - 1,
                    ])>
                    <div class="flex gap-1">
                        <p>Next</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-arrow-big-right-dash-icon lucide-arrow-big-right-dash pt-1">
                            <path
                                d="M11 9a1 1 0 0 0 1-1V5.061a1 1 0 0 1 1.811-.75l6.836 6.836a1.207 1.207 0 0 1 0 1.707l-6.836 6.835a1 1 0 0 1-1.811-.75V16a1 1 0 0 0-1-1H9a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z" />
                            <path d="M4 9v6" />
                        </svg>
                    </div>
                </button>
            </div>

        </div>
        {{-- Question List --}}
        <div x-data="{ minimize: false }">

            {{-- Header Daftar Soal --}}

            <x-card class="font-bold text-4xl mb-2 flex justify-between">
                <p class=" text-slate-600">Daftar Soal</p>
                <div>
                    <span x-cloak x-show="!minimize" x-on:click="minimize = !minimize" title="Minimize"
                        class="text-slate-400 cursor-pointer hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-up">
                            <path d="m18 15-6-6-6 6" />
                        </svg>
                    </span>

                    <span x-cloak x-show="minimize" x-on:click="minimize = !minimize" title="Expand"
                        class="text-slate-400 cursor-pointer hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-down">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </span>
                </div>
            </x-card>

            {{-- Question Button Number --}}

            <div x-cloak x-show="!minimize" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-80 opacity-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="max-h-80 opacity-100" x-transition:leave-end="max-h-0 opacity-0"
                class="overflow-hidden mb-2">
                <x-card class=" grid md:grid-cols-4 grid-cols-6 gap-2 overflow-y-auto max-h-80 ">
                    @foreach ($exam['questions'] as $index => $question)
                        <x-card wire:click.debounce.100ms="changeIndex({{ $index }})"
                            @class([
                                'shadow-none border border-slate-400 text-center font-bold text-secondary-400 transition',
                                'hover:ring-2 hover:ring-secondary-500 hover:ring-offset-0 cursor-pointer relative',
                                'bg-secondary-700/30 text-white' =>
                                    ($answer[$question['id']] ?? null) != null,
                                'ring-4 ring-offset-0 ring-danger-400 relative' => $index == $currentIndex,
                                'bg-secondary-700/30 text-white ring-4 ring-offset-0 ring-danger-300 shadow-sm relative' =>
                                    $index == $currentIndex && ($answer[$question['id']] ?? null) != null,
                            ])>
                            {{ $index + 1 }}

                            @if (($markedQuestions[$question['id']] ?? null) == true)
                                <div class=" absolute p-0 m-0 top-1/2 -mt-12 -mr-1 right-1 text-5xl text-warning-600 ">
                                    &#x2022;
                                </div>
                            @endif

                        </x-card>
                    @endforeach
                </x-card>
            </div>

            {{-- Timer --}}

            <livewire:student.exam-attempt-component.timer :examDuration="$examAssignment['duration']" :usedDuration="$examTakerData['duration_used']" :examTakerData="$examTakerData" />

            {{-- Submit Button --}}

            <div class=" mt-2" x-data="{ modal: false }">
                <x-submit-button class=" rounded-md" x-on:click="modal = !modal">
                    Submit
                </x-submit-button>
                <x-modal x-show="modal" :message="'Akhiri Ujian Sekarang?'">
                    <x-submit-button wire:click="submit">
                        Konfirmasi
                    </x-submit-button>
                </x-modal>
            </div>

        </div>



    </div>


    <div x-data="{
        modal: false
    }" x-on:time-limit-reached.window="
        modal = true
     ">
        <x-modal x-show="modal" :message="'Waktu Ujian Habis'" :disabled="true">
            <x-submit-button wire:click="submit">Kembali Ke Daftar Ujian</x-submit-button>
        </x-modal>
    </div>

</div>
