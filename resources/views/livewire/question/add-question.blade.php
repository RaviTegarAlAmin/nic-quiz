<div class=" mt-4">

    @if ($questions)
        @foreach ($questions as $index => $question)
            <div wire:key="question-{{ $index }}">
                <x-card class=" mb-8 transition border-t-8 border-secondary-400 border-b-8 drop-shadow-xl border-b-gray-400" x-data="{ minimize: $wire.entangle('minimize.{{ $question['id'] }}') }">
                    {{-- Header function --}}
                    <div class="flex justify-between -mt-4 py-2">

                        {{-- Question Number and Question Preview --}}
                        <div class="flex gap-2 align-middle">
                            <x-label>{{ $index + 1 }}</x-label>
                            <x-label x-show="minimize"
                                class=" text-slate-400">{{ Str::length($question['question']) > 0 ? substr($question['question'], 0, 50) . '...' : 'Soal kosong...' }}</x-label>
                        </div>
                        {{-- Button for minimize, delete, and duplicate --}}
                        <div class=" flex gap-2">
                            {{-- Minimize / Expand Button --}}
                            <div>
                                <x-tag x-show="minimize">
                                    {{ $question['type'] == 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }}
                                </x-tag>
                            </div>
                            <div>
                                <span wire:click="toggleMinimize({{ $question['id'] }})" x-show="!minimize"
                                    title="Minimize" class="text-slate-400 cursor-pointer hover:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-up-icon lucide-chevron-up">
                                        <path d="m18 15-6-6-6 6" />
                                    </svg>
                                </span>

                                <span wire:click="toggleMinimize({{ $question['id'] }})" x-show="minimize"
                                    title="Expand" class="text-slate-400 cursor-pointer hover:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-chevron-down-icon lucide-chevron-down">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </span>
                            </div>
                            {{-- Delete Button --}}
                            <div wire:click="deleteQuestion({{ $question['id'] }})">
                                <span title="Hapus Pertanyaan"
                                    class="text-slate-400 cursor-pointer hover:text-danger-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash2-icon lucide-trash-2">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr class=" bg-secondary-200 w-full mx-auto h-0.5 mb-3">
                    {{-- Body Function For Question General Info --}}
                    <div x-show="!minimize" class=" grid grid-cols-4 gap-4 mb-4">

                        <div class=" row-span-2 col-span-3">
                            <x-label>Pertanyaan</x-label>
                            <x-form-input type="textarea"
                                wire:model.live="questions.{{ $index }}.question"></x-form-input>
                        </div>
                        <div>
                            <x-label>Tipe Soal</x-label>
                            <select wire:model.live="questions.{{ $index }}.type" id="question.type"
                                class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none">
                                @foreach ($typeList as $label => $type)
                                    <option value="{{ $type }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-label>Bobot</x-label>
                            <x-form-input min="1" type="number" wire:model.live="questions.{{ $index }}.weight" />
                            @error('weight')
                                {{ $message }}
                            @enderror
                        </div>
                        {{-- Specific Question Related --}}
                        <div class=" col-span-4">
                            @if ($question['type'] == 'multiple_choice')
                                <div class=" grid grid-cols-2 w-full gap-2">
                                    @foreach ($options[$question['id']] as $index => $option)
                                        <div x-data="{ checkHover: false }" class=" relative group">
                                            <x-form-input type="textarea" col="30" row="2"
                                                name="{{ $option['label'] }}"
                                                wire:model.live="options.{{ $question['id'] }}.{{ $index }}.option"
                                                wire:key="option-{{ $question['id'] }}-{{ $index }}"
                                                x-bind:class="checkHover
                                                    ?
                                                    'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border' :
                                                    ''">
                                            </x-form-input>
                                            <div class=" absolute top-2 right-2 text-secondary-400"
                                                x-on:mouseover="checkHover= !checkHover"
                                                x-on:mouseout="checkHover = !checkHover"
                                                wire:click="toggleCorrectAnswer({{ $question['id'] }},{{ $option['label'] }})"
                                                x-bind:class="checkHover ? ' text-white' : '' ">
                                                @if ($question['ref_answer'] == $option['label'])
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="35"
                                                        height="35" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-square-check-big-icon lucide-square-check-big">
                                                        <path
                                                            d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                                        <path d="m9 11 3 3L22 4" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="35"
                                                        height="35" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-square-icon lucide-square">
                                                        <rect width="18" height="18" x="3" y="3"
                                                            rx="2" />
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @elseif ($question['type'] == 'essay')
                                <div>
                                    <x-label>Jawaban</x-label>
                                    <x-form-input type="textarea" :row="2"
                                        wire:model.live="questions.{{ $index }}.ref_answer">
                                    </x-form-input>
                                </div>
                            @endif
                        </div>
                    </div>

                </x-card>
            </div>
        @endforeach
    @else
        <div class=" text-center text-slate-400 py-5">
            <p class="mb-5">Tidak ada pertanyaan</p>
            <hr class=" mx-auto w-3/4 h-0.5 bg-secondary-300-0.75">
        </div>
    @endif

    <div wire:click="addQuestion"
        class=" text-xl text-slate-200 rounded-md text-center py-6 border-4 border-dashed border-slate-150 hover:text-secondary-400 hover:border-secondary-300 cursor-pointer">
        <p class=" text-4xl">+</p>
        <p>Tambah Pertanyaan</p>
    </div>
</div>
